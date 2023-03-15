<?php

namespace App\Models;

use CodeIgniter\Model;

class Candidates extends Model
{
    protected $table            = 'candidates';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = [
        'first_name',
        'last_name',
        'dob',
        'email',
        'education',
        'attachment_ml',
        'attachment_cv',
        'attachment_other_status'
    ];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules      = [
        'first_name' => 'required|max_length[255]|min_length[2]',
        'last_name' => 'required|min_length[2]',
        'email' => 'required|valid_email|max_length[255]',
        'education' => 'required|min_length[1]',
        'attachment_other_status' => 'required|min_length[1]',
    ];
    protected $validationMessages   = [
        'first_name' => [
            'required' => 'Pole Imię jest puste.',
        ],
        'last_name' => [
            'required' => 'Pole Nazwisko jest puste.',
        ],
        'email' => [
            'required' => 'Pole Email jest puste.',
        ],
        'education' => [
            'required' => 'Pole Wykształcenie jest puste.',
        ],
        'attachment_other_status' => [
            'required' => 'Pole Wykształcenie jest puste.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function put($data){
        $query = $this->db->table($this->table)->insert($data);
        return true;
    }

}