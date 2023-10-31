<?php

defined('BASEPATH') or exit('No direct script access allowed');

class dashbord extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('admin_login')) {
            redirect(base_url('login/verify'));
        }
    }
    public function index()
    {
        // $this->load->view('admin/dashbord');
        $data['page_title'] = "Dashbord | Admin";
        $data['page_name'] = "admin/dashbord";
        $this->load->view('admin/common', $data);
    }
}
