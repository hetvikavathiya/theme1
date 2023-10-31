<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Change_password extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->has_userdata('admin_login')) {
            $message = ['class' => 'danger', 'message' => 'Your Session hase been Expired!! '];
            $this->session->set_flashdata('flash', $message);
            redirect(base_url('admin_login'));
        }
    }

    public function index()
    {
        $page_data['page_name'] = 'admin/change_password';
        $page_data['page_title'] = 'Change Password';
        $this->load->view('admin/common', $page_data);
    }
    public function change()
    {
        $this->form_validation->set_rules('old_password', 'Old Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

        if ($this->form_validation->run() == false) {
            $message = array('message' => validation_errors(), 'class' => 'danger');
            $this->session->set_flashdata('flash', $message);
            redirect(base_url('admin/change_password'));
        } else {
            $user_id = $this->session->userdata('admin_login')['user_id'];
            $data = $this->input->post();
            $old_password = $this->db->get_where('users', array('user_id' => $user_id))->row('password');
            if ($data['old_password'] == $old_password) {
                $update = $this->db->where('user_id', $user_id)->update("users", array('password' => $data['new_password']));
                if ($update) {
                    $message = array('message' => "Change Password Successfully!", 'class' => 'success');
                } else {
                    $message = array('message' => "Failed To Change Password.", 'class' => 'danger');
                }
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/change_password'));
            } else {
                $message = array('message' => "Incorrect current password", 'class' => 'danger');
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/change_password'));
            }
        }
    }
}
