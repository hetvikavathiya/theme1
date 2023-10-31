<?php

defined('BASEPATH') or exit('No direct script access allowed');

class category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('admin_login')) {
            redirect(base_url('login/verify'));
        }
    }
    public function category($params = "", $params1 = "")
    {

        if ($params == "") {
            $data['page_title'] = "category | Admin";
            $data['page_name'] = "admin/category";
            $data['data'] = $this->db->get('category')->result_array();
            $this->load->view('admin/common', $data);
        }
        if ($params == "add") {
            $this->form_validation->set_rules('name', 'name', 'required');
            if ($this->form_validation->run() == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
            } else {
                $category = $this->input->post('name');
                // $user = $this->session->userdata('admin_login')['username'];
                $this->db->insert('category', ['name' => $category]);

                $message = ['class' => 'success my-3', 'message' => 'Category Added Successfully !!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/category/category'));
            }
        }
        if ($params == "edit") {
            $id = $params1;
            $page_data['page_title'] = "Edit category ";
            $page_data['page_name'] = "admin/category";
            $page_data['update_data'] = $this->db->get_where('category', ['id' => $id])->row_array();
            $page_data['data'] = $this->db->get('category')->result_array();
            $this->load->view('admin/common', $page_data);
        }
        if ($params == "delete") {
            $id = $params1;
            $query = $this->db->get_where('category', ['id' => $id]);
            if ($query->num_rows() > 0) {
                $this->db->where('id', $id)->delete('category');
                $message = ['class' => 'success my-3', 'message' => 'Category deleted successfully!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/category/category'));
            } else {
                $message = ['class' => 'success my-3', 'message' => 'category  not deleted!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/category/category'));
            }
        }
        if ($params == "update") {
            $this->form_validation->set_rules('name', 'name', 'required');
            if ($this->form_validation->run() == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
            } else {
                $id = $this->input->post('id');
                $category = $this->input->post('name');
                $query = $this->db->get_where('category', ['id' => $id]);
                if ($query->num_rows() == 1) {
                    if ($category == $query->row()->name) {
                        $message = ['class' => 'danger my-3', 'message' => 'category does not updated'];
                        $this->session->set_flashdata('flash', $message);
                        redirect(base_url('admin/category/category/edit/') . $id);
                    } else {
                        $this->db->where('id', $id)->update('category', ['name' => $category]);
                        $message = ['class' => 'success my-3', 'message' => 'category updated successfully!'];
                        $this->session->set_flashdata('flash', $message);
                        redirect(base_url('admin/category/category'));
                    }
                } else {
                    redirect(base_url('admin/category/category'));
                }
            }
        }
    }
}
