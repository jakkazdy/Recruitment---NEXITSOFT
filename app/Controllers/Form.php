<?php

namespace App\Controllers;

class Form extends BaseController
{
    public function index()
    {
        $data['title'] = ucfirst('Rekrutacja');
        return view('templates/header', $data)
            . view('form/index')
            . view('templates/footer');
    }

}