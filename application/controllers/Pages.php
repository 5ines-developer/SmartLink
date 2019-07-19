<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_account');
        $this->load->model('m_authendication');
    }


    public function terms($value='')
    {
        $this->load->view('pages/terms-condition.php');
    }

}