<?php

defined('BASEPATH') or exit('No direct script access allowed');

class subcategory extends CI_Controller
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
            $result = $this->db->select('SC.*,C.name as category')
                ->join('category C', 'C.id = SC.category_id', "left")
                ->get('subcategory SC')->result_array();

            $data['page_title'] = "subcategory | Admin";
            $data['page_name'] = "admin/subcategory";
            $data['data'] = $result;
            $this->load->view('admin/common', $data);
        }
        if ($params == "add") {
            $this->form_validation->set_rules('category_id', 'category_id', 'required');
            $this->form_validation->set_rules('name', 'name', 'required');
            if ($this->form_validation->run() == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
            } else {

                // $category = $this->input->post('category_id');
                // $subcategory = $this->input->post('name');
                $data = $this->input->post();
                $this->db->insert('subcategory', $data);
                $message = ['class' => 'success my-3', 'message' => 'subcategory Added Successfully !!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/subcategory'));
            }
        }
        if ($params == "edit") {
            $query = $this->db->get_where('subcategory', ['id' => $id]);
            if ($query->num_rows() == 1) {
                $page_data['page_title'] = "Edit subcategory ";
                $page_data['page_name'] = "admin/subcategory";
                $page_data['update_data'] = $this->db->get_where('subcategory', ['id' => $id])->row_array();
                $page_data['data']  = $this->db->select('SC.*,C.name as category')
                    ->join('category C', 'C.id = SC.category_id', "left")
                    ->get('subcategory SC')->result_array();

                $this->load->view('admin/common', $page_data);
            } else {
                $message = ['class' => 'danger my-3', 'message' => 'subcategory does not exist'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/subcategory'));
            }
        }
        if ($params == "delete") {

            $query = $this->db->get_where('subcategory', ['id' => $id]);
            if ($query->num_rows() > 0) {
                $this->db->where('id', $id)->delete('subcategory');
                $message = ['class' => 'success my-3', 'message' => 'subcategory deleted successfully!'];
            } else {
                $message = ['class' => 'success my-3', 'message' => 'subcategory  not deleted!'];
            }
            $this->session->set_flashdata('flash', $message);
            redirect(base_url('admin/subcategory'));
        }
        if ($params == "update") {
            
            $id = $this->input->post('id');
            $data = $this->input->post();
            $query = $this->db->get_where('subcategory', ['id' => $id]);
            if ($query->num_rows() == 1) {

                $this->db->where('id', $id)->update('subcategory', $data);
                $message = ['class' => 'success my-3', 'message' => 'subcategory updated successfully!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/subcategory/'));
            } else {
                $message = ['class' => 'danger my-3', 'message' => 'subcategory does not updated'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/subcategory/'));
            }
        }
    }
}
