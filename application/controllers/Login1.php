<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login1 extends CI_Controller
{
    function index()
    {
        require('Textlocal.class.php');
        $Textlocal = new Textlocal(false, false, 'API_KEY');

        $numbers = array(MOBILE);
        $sender = 'Hetvi';
        $name = $this->input->post('name');
        $otp = mt_rand(10000, 99999);
        $message = 'hello' . $name . 'this is your otp' . $otp;

        $response = $Textlocal->sendSms($numbers, $message, $sender);
        print_r($response);

        $this->load->view('admin/login1');
    }
}
