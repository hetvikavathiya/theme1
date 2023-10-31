<?php

defined('BASEPATH') or exit('No direct script access allowed');

class customber extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('admin_login')) {
            redirect(base_url('login/verify'));
        }
    }

    public function index($params = "", $params1 = "")
    {
        $id = $params1;
        if ($params == "") {
            $data['page_title'] = "customber | Admin";
            $data['page_name'] = "admin/customber";
            $data['data'] = $this->db->get('customber')->result_array();
            $this->load->view('admin/common', $data);
        }
        if ($params == "add") {
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('number', 'number', 'required|min_length[10]|max_length[10]');
            if ($this->form_validation->run() == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/customber'));
            } else {

                $name = $this->input->post('name');
                $number = $this->input->post('number');
                $this->db->insert('customber', ['name' => $name, 'number' => $number,]);
                $message = ['class' => 'success my-3', 'message' => 'customber Added Successfully !!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/customber'));
            }
        }
        if ($params == "edit") {
            $query = $this->db->get_where('customber', ['cid' => $id]);
            if ($query->num_rows() == 1) {
                $page_data['page_title'] = "Edit customber ";
                $page_data['page_name'] = "admin/customber";
                $page_data['update_data'] = $this->db->get_where('customber', ['cid' => $id])->row_array();
                $page_data['data']  = $this->db->get('customber')->result_array();

                $this->load->view('admin/common', $page_data);
            } else {
                $message = ['class' => 'danger my-3', 'message' => 'customber does not exist'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/customber'));
            }
        }
        if ($params == "delete") {

            $query = $this->db->get_where('customber', ['cid' => $id]);
            if ($query->num_rows() > 0) {
                $this->db->where('cid', $id)->delete('customber');
                $message = ['class' => 'success my-3', 'message' => 'customber deleted successfully!'];
            } else {
                $message = ['class' => 'success my-3', 'message' => 'customber  not deleted!'];
            }
            $this->session->set_flashdata('flash', $message);
            redirect(base_url('admin/customber'));
        }
        if ($params == "update") {
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('number', 'number', 'required|min_length[10]|max_length[10]');
            if ($this->form_validation->run() == FALSE) {

                $message = ['class' => 'danger', 'message' => validation_errors()];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/customber'));
            }
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $number = $this->input->post('number');
            $query = $this->db->get_where('customber', ['cid' => $id]);
            if ($query->num_rows() == 1) {

                $this->db->where('cid', $id)->update('customber', ['name' => $name, 'number' => $number]);
                $message = ['class' => 'success my-3', 'message' => 'customber updated successfully!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/customber/'));
            } else {
                $message = ['class' => 'danger my-3', 'message' => 'customber does not updated'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/customber/'));
            }
        }
    }
}
