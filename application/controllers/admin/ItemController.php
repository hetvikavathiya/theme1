<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ItemController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function fetch_items()
    {
        $query = $this->db->get('category');
        $data['items'] = $query->result();
        echo json_encode($data['items']);
    }
    public function index($params = "", $params1 = "")
    {
        if ($params == "") {
            $data['page_title'] = "selected2dropdoun | Admin";
            $data['page_name'] = "admin/selected2dropdoun";
            $data['data'] = $this->db->select('i.*,C.name as category')
                ->join('category C', 'C.id = i.category_id', "left")
                ->get('itemselect i')->result_array();
            $this->load->view('admin/common', $data);
        }
        if ($params == "add") {
            $this->form_validation->set_rules('category_id', 'category_id', 'required');
            if ($this->form_validation->run() == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
            } else {
                $category_id = $this->input->post('category_id');
                $this->db->insert('itemselect', ['category_id' => $category_id]);

                $message = ['class' => 'success my-3', 'message' => 'Category Added Successfully !!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/ItemController'));
            }
        }
        if ($params == "edit") {
            $id = $params1;
            $page_data['page_title'] = "Edit ItemController ";
            $page_data['page_name'] = "admin/selected2dropdoun";
            $page_data['update_data'] = $this->db->get_where('itemselect', ['id' => $id])->row_array();
            $page_data['data'] = $this->db->select('i.*,C.name as category')
                ->join('category C', 'C.id = i.category_id', "left")
                ->get('itemselect i')->result_array();
            $this->load->view('admin/common', $page_data);
        }
        if ($params == "delete") {
            $id = $params1;
            $query = $this->db->get_where('itemselect', ['id' => $id]);
            if ($query->num_rows() > 0) {
                $this->db->where('id', $id)->delete('itemselect');
                $message = ['class' => 'success my-3', 'message' => 'Category deleted successfully!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/ItemController'));
            } else {
                $message = ['class' => 'success my-3', 'message' => 'category  not deleted!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/ItemController'));
            }
        }
        if ($params == "update") {
            $this->form_validation->set_rules('category_id', 'category_id', 'required');
            if ($this->form_validation->run() == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
            } else {
                $id = $this->input->post('id');
                $category_id = $this->input->post('category_id');
                $query = $this->db->get_where('itemselect', ['id' => $id]);
                if ($query->num_rows() == 1) {
                    if ($category_id == $query->row()->itemselect) {
                        $message = ['class' => 'danger my-3', 'message' => 'category does not updated'];
                        $this->session->set_flashdata('flash', $message);
                        redirect(base_url('admin/ItemController/index/edit/') . $id);
                    } else {
                        $this->db->where('id', $id)->update('itemselect', ['category_id' => $category_id]);
                        $message = ['class' => 'success my-3', 'message' => 'category updated successfully!'];
                        $this->session->set_flashdata('flash', $message);
                        redirect(base_url('admin/ItemController'));
                    }
                } else {
                    redirect(base_url('admin/ItemController'));
                }
            }
        }
    }
}
