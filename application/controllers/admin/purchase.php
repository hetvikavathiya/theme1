<?php
defined('BASEPATH') or exit('No direct script access allowed');

class purchase extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('admin_login')) {
            redirect(site_url('login/verify'), 'refresh');
        }
    }



    public function index($params = "", $params1 = "")
    {

        $id = $params1;
        if ($params == "") {
            $data['page_title'] = "purchase Iteam";
            $data['page_name'] = 'admin/purchase';
            $data['purchase'] = $this->db->get('purchase')->result_array();
            $this->load->view('admin/common', $data);
        }


        if ($params == "add") {

            $this->form_validation->set_rules('date', 'date', 'required');
            $this->form_validation->set_rules('customber_id', 'customber_id', 'required');
            $this->form_validation->set_rules('product_id', 'product_id', 'required');
            $this->form_validation->set_rules('price', 'price', 'required');
            $this->form_validation->set_rules('quantity', 'quantity', 'required');
            $this->form_validation->set_rules('totalprice', 'totalprice', 'required');
            if ($this->form_validation->run() == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/purchase/'));
            } else {
                $data = $this->input->post();
                $this->db->insert('purchase', $data);
                $message = ['class' => 'success my-3', 'message' => 'purchase product Added Successfully !!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/purchase/report'));
            }
        }
        if ($params == "edit") {

            $query = $this->db->get_where('purchase', ['id' => $id]);
            if ($query->num_rows() == 1) {
                $page_data['page_title'] = "Edit purchase ";
                $page_data['page_name'] = "admin/purchase";
                $page_data['update_data'] = $this->db->get_where('purchase', ['id' => $id])->row_array();
                $this->load->view('admin/common', $page_data);
            } else {
                $message = ['class' => 'danger my-3', 'message' => 'purchase does not exist'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/purchase'));
            }
        }
        if ($params == "delete") {
            $id = $params1;
            $query = $this->db->get_where('purchase', ['id' => $id]);
            if ($query->num_rows() > 0) {
                $this->db->where('id', $id)->delete('purchase');
                $message = ['class' => 'success my-3', 'message' => 'purchase product deleted successfully!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/purchase'));
            } else {
                $message = ['class' => 'success my-3', 'message' => 'purchase product  not deleted!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/purchase/report'));
            }
        }
        if ($params == "update") {

            $this->form_validation->set_rules('date', 'date', 'required');
            $this->form_validation->set_rules('customber_id', 'customber_id', 'required');
            $this->form_validation->set_rules('product_id', 'product_id', 'required');
            $this->form_validation->set_rules('price', 'price', 'required');
            $this->form_validation->set_rules('quantity', 'quantity', 'required');
            $this->form_validation->set_rules('totalprice', 'totalprice', 'required');
            if ($this->form_validation->run() == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/purchase/'));
            } else {
                $id = $this->input->post('id');
                $data = $this->input->post();
                $query = $this->db->get_where('purchase', ['id' => $id]);
                if ($query->num_rows() == 1) {

                    $this->db->where('id', $id)->update('purchase', $data);
                    $message = ['class' => 'success my-3', 'message' => 'purchase product updated successfully!'];
                    $this->session->set_flashdata('flash', $message);
                    redirect(base_url('admin/purchase/'));
                } else {
                    $message = ['class' => 'danger my-3', 'message' => 'purchase product does not updated'];
                    $this->session->set_flashdata('flash', $message);
                    redirect(base_url('admin/purchase/report'));
                }
            }
        }
    }


    public function report()
    {
        $data['page_title'] = "Purchase Report | Admin";
        $data['page_name'] = "admin/purchase_report";
        $this->load->view('admin/common', $data);
    }
    public function getlist()
    {
        $postData = $this->security->xss_clean($this->input->post());
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length'];
        
        // serching coding
        $columnIndex = $postData['order'][0]['column']; // Column index
        $searchValue = $postData['search']['value']; // Search value
        $customber_id = $postData['customber'];
        $todate = $postData['todate'];
        $fromdate = $postData['fromdate'];

        # Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = " (date like '%" . $searchValue . "%'  or customber.name like '%" . $searchValue . "%'  or product.name like '%" . $searchValue . "%' or quantity like'%" . $searchValue . "%') ";
        }
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $records = $this->db->get('purchase')->result();
        $totalRecords = $records[0]->allcount;


        ## Total number of record with filtering
        $this->db->select('purchase.*,customber.name as cname,product.name as pname');
        $this->db->from('purchase');
        $this->db->join('customber', 'customber.cid = purchase.customber_id', 'left');
        $this->db->join('product', 'product.id = purchase.product_id', 'left');

        if ($searchQuery != '')
            $this->db->where($searchQuery);
        if (!empty($customber_id)) {
            $this->db->where('purchase.customber_id', $customber_id);
        }
        if (!empty($fromdate)) {
            $this->db->where('DATE(purchase.date) >=', $fromdate);
        }
        if (!empty($todate)) {
            $this->db->where('DATE(purchase.date) <=', $todate);
        }

        $records = $this->db->get();
        $totalRecordwithFilter = $records->num_rows();

        ## Fetch records

        $this->db->select('purchase.*,customber.name as cname,product.name as pname');
        $this->db->from('purchase');
        $this->db->join('customber', 'customber.cid = purchase.customber_id', 'left');
        $this->db->join('product', 'product.id = purchase.product_id', 'left');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        if (!empty($customber_id)) {
            $this->db->where('purchase.customber_id', $customber_id);
        }
        if (!empty($fromdate)) {
            $this->db->where('DATE(purchase.date) >=', $fromdate);
        }
        if (!empty($todate)) {
            $this->db->where('DATE(purchase.date) <=', $todate);
        }
        //$this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();


        $data = array();
        $i = $start + 1;
        foreach ($records as $record) {
            // $img = "<img src='" . $record->productimage . "' />";
            $action = '
            <a href="index/edit/' . $record->id . '" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i>Edit</a>
            <a href="index/delete/' . $record->id . '" class="btn btn-danger del" ><i class="fa-solid fa-trash"></i>Delete</a>
            ';
            $data[] = array(
                'id' => $i,
                'date' => $record->date,
                'customber' => $record->cname,
                'product' =>  $record->pname,
                'price' => $record->price,
                'quantity' => $record->quantity,
                'totalprice' => $record->totalprice,
                'action' => $action,
            );
            $i = $i + 1;
        }


        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
        );
        echo json_encode($response);
        exit();
    }
    // public function getprice()
    // {
    //     $post = $this->input->post();
    //     if (isset($post['product_id'])) {
    //         $id = $post['product_id'];
    //         $price = $this->db->where('id', $id)->get('product')->row_array()['price'];
    //         echo $price;
    //     }
    // }
}
