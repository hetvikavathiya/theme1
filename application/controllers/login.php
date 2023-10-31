<?php
defined('BASEPATH') or exit('No direct script access allowed');

class login extends CI_Controller
{
    public function verify()
    {
        $this->form_validation->set_rules('mobile_no', 'mobile_no', 'trim|required');
        $this->form_validation->set_rules('password', 'Password ', 'trim|required');
        $login_user = [
            'mobile_no' => $this->input->post("mobile_no"),
            'password' => $this->input->post("password")
        ];
        if ($this->form_validation->run() == true) {

            if ($this->db->get_where('users', ['mobile_no' => $login_user['mobile_no']])->num_rows() == 1) {

                if ($this->db->get_where('users', $login_user)->num_rows() == 1) {

                    $user = $this->db->get_where('users', $login_user)->row_array();
                    $loged_user = array(
                        'user_id' => $user['user_id'],
                        'mobile_no' => $user['mobile_no'],
                        'username' => $user['username'],
                        'login' => true
                    );

                    $this->session->set_userdata('admin_login', $loged_user);
                    $message = ['class' => 'success my-2', 'message' => 'login in successfully'];
                    $this->session->set_flashdata('flash', $message);
                    redirect(base_url('admin/dashbord'));
                } else {
                    $message = ['class' => 'danger', 'message' => 'Enter valid Password'];
                    $this->session->set_flashdata('flash', $message);
                    redirect('login/verify');
                }
            } else {
                $message = ['class' => 'danger', 'message' => 'Invalid Mobile Number'];
                $this->session->set_flashdata('flash', $message);
                redirect('login/verify');
            }
        } else {
            $this->load->view('login');
        }
    }

    public function forgot_password()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('email', 'email', 'required');
            if ($this->form_validation->run() == TRUE) {
                $email = $this->input->post('email');
                $query = $this->db->query("SELECT * FROM users WHERE email=$email");
                if ($query->num_rows() != false) {
                    $row = $query;
                    $user_id = $row->user_id;
                    $string = time() . $user_id . $email;
                    $hash_string = hash('sha256', $string);
                    $current_date = date('y-m-d H:i');
                    $hash_expiry = date('y-m-d H:i', strtotime($current_date . '1 days'));
                    $data = array(
                        'hash_key' => $hash_string,
                        'hash_expiry' => $hash_expiry
                    );
                    $this->db->where('email', $email);
                    $this->db->update('users', $data);

                    $resetlink = base_url() . 'reset/password?hash=' . $hash_string;
                    $message = "your reset password link is here" . $resetlink;
                } else {
                    $message = ['class' => 'success my-3', 'message' => 'Invalid Email Id !!'];
                    $this->session->set_flashdata('flash', $message);
                }
            } else {
                $this->load->view('forgot_password');
            }
        } else {
            $this->load->view('forgot_password');
        }
    }



    public function logout()
    {
        $this->session->unset_userdata('admin_login');
        $message = ['class' => 'danger', 'message' => 'logout Successfully !'];
        $this->session->set_flashdata('flash', $message);
        redirect(base_url('login/verify'));
    }
}
