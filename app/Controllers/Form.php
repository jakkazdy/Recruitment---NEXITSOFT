<?php

namespace App\Controllers;

use App\Models\Candidates as CandidatesModel;
use App\Models\Attachment as AttachmentModal;
use App\Models\Internship as InternshipModal;
use App\Controllers\FormRecruitment\Validation;

class Form extends BaseController
{

    public function index(array $error=[])
    {
        $data['title'] = ucfirst('Rekrutacja');
        $data['inputs'] = $this->formInit();
        $data['error'] = $error;
        return view('templates/header', $data)
            . view('form/index')
            . view('templates/footer');
    }

    public function send()
    { 
        $data['title'] = ucfirst('Rekrutacja');
        if($this->validationForms()==true){
            if($this->saveForm()===true){
                return view('templates/header', $data)
                . view('form/thanks')
                . view('templates/footer');
            }else{
                print_r($this->validator->getErrors());
            }
        }else{
            return $this->index($this->validator->getErrors());
        }
    }

    public function ajaxGeneratingFormInternship($n=0)
    {
        return view('form/internship_add', ['number'=>$n]);
    }

    public function saveForm(){
        try{
            $uploadName=$this->uploadAttachments();

            $CandidatesData=[
                'first_name'=>$this->request->getPost('first_name'),
                'last_name'=>$this->request->getPost('last_name'),
                'dob'=>$this->request->getPost('dob'),
                'email'=>$this->request->getPost('email'),
                'education'=>$this->request->getPost('education'),
                'attachment_ml'=>$uploadName['nameLM'],
                'attachment_cv'=>$uploadName['nameCV'],
                'attachment_other_status'=>$this->request->getPost('attachment_other_status'),
            ];

            if(!$this->saveCandidates($CandidatesData,$uploadName)){
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function validationForms(){
        Validation::index();
    }

    private function saveCandidates($data,$uploadName){
        $post=$this->request->getPost();
        $Candidates = new CandidatesModel();
        if(!$Candidates->insert($data)){
            return false;
        }

        $Internship = new InternshipModal();

        for($n=0;$n<=$post['internshipCount'];$n++){
            if(!empty($post['internship'][$n]['name']) &&
            !empty($post['internship'][$n]['start']) &&
            !empty($post['internship'][$n]['start'])){
                $Internship->insert([
                    'id_candidate'=>$Candidates->getInsertID(),
                    'name_brand'=>$post['internship'][$n]['name'],
                    'date_start'=>$post['internship'][$n]['start'],
                    'date_end'=>$post['internship'][$n]['end']
                ]);
            }
        }

        $Attachment = new AttachmentModal();
        if(!$Attachment->where('name_file',$uploadName['nameOTHER'])->set('id_candidate',$Candidates->getInsertID())->update()){
            return false;
        }

        return true;

    }
    private function validationAttachments(){
        
        $validatedCV = $this->validate([
            'attachmentCV' => [
                'uploaded[attachmentCV]',
                'ext_in[attachmentCV,jpg,jpeg,pdf,doc]',
                'max_size[attachmentCV,4096]',
            ],
        ]);
        $validatedLM = $this->validate([
            'attachmentLM' => [
                'uploaded[attachmentLM]',
                'ext_in[attachmentLM,jpg,jpeg,pdf,doc]',
                'max_size[attachmentLM,4096]',
            ],
        ]);
        $validatedOther = $this->validate([
            'attachmentOther' => [
                'max_size[attachmentOther,4096]',
            ],
        ]);

        if (!$validatedCV AND !$validatedLM) {
            return false;
        }
        return true;
    }
    private function uploadAttachments(){
        $fileLM = $this->request->getFile('attachmentLM');
        $fileCV = $this->request->getFile('attachmentCV');
        $fileOTHER = $this->request->getFile('attachmentOther');
        $addDateName= date('Ymd_his');
        $nameLM=$addDateName.$fileLM->getName();
        $nameCV=$addDateName.$fileCV->getName();
        $fileLM->move(WRITEPATH . 'uploads', $nameLM);
        $fileCV->move(WRITEPATH . 'uploads', $nameCV);
        if(file_exists($fileOTHER)){

            $nameOTHER=$addDateName.$fileOTHER->getName();
            $Attachment = new AttachmentModal();
            $Attachment->insert([
                'id_candidate'=>0,
                'name_file'=>$nameOTHER,
            ]);
            $fileOTHER->move(WRITEPATH . 'uploads', $addDateName.$fileOTHER->getName());
        }else{
            $nameOTHER='';
        }
        return ['nameLM'=>$nameLM,'nameCV'=>$nameCV,'nameOTHER'=>$nameOTHER,];
    }

    private function validationCandidates(){
        $post=$this->request->getPost();
        if (! $this->validateData($post, [
            'first_name' => 'required|max_length[100]|min_length[2]',
            'last_name'  => 'required|max_length[100]|min_length[2]',
            'dob'  => 'required|max_length[10]|min_length[10]',
            'education'  => 'required',
            'email'  => 'required|max_length[255]|min_length[5]',
            'internshipCount'  => 'required|numeric|max_length[2]|min_length[1]',
        ])) {
            return false;
        }
        return true;
    }

    private function validationInternships(){
        $post=$this->request->getPost();
        // echo '<pre>';
        // print_r($post);
        for($n=0;$n<$post['internshipCount'];$n++){

            if(!empty($post['internship'][$n]['name']) &&
                !empty($post['internship'][$n]['start']) &&
                !empty($post['internship'][$n]['start'])){

                if($this->validationInternshipRules([
                    'name'=>$post['internship'][$n]['name'],
                    'dateStart'=>$post['internship'][$n]['start'],
                    'dateEnd'=>$post['internship'][$n]['end'],
                    'number'=>$n,
                ])==false){
                    return false;
                }

            }
        }
        return true;
    }

    private function validationInternshipRules($data){
        $rules=[
            'name' => 'required',
            'dateStart'  => 'required',
            'dateEnd'  => 'required',
            'number'  => 'integer',
        ];
        if (! $this->validateData($data, $rules)) {
            return false;
        }
        return true;
    }

    private function formInit()
    {
        return [
            'first_name'=>[
                'type'=>'text',
                'name'=>'first_name',
                'class'=>'form-control',
            ],
            'last_name'=>[
                'type'=>'text',
                'name'=>'last_name',
                'class'=>'form-control',
            ],
            'dob'=>[
                'type'=>'date',
                'name'=>'dob',
                'class'=>'form-control dateValidation',
            ],
            'email'=>[
                'type'=>'email',
                'name'=>'email',
                'class'=>'form-control',
            ],
        ];
    }
}