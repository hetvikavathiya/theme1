<?php
defined('BASEPATH') or exit('No direct script access allowed');

class purchase_selected2 extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        chech_login();
    }

    public function index($params = "", $params1 = "")
    {

        $id = $params1;
        if ($params == "") {
            $data['page_title'] = "purchase selected2 Iteam";
            $data['page_name'] = 'admin/purchase_selected2';
            $this->load->view('admin/common', $data);
        }


        if ($params == "add") {

            $this->form_validation->set_rules('customber_id', 'customber_id', 'required');
            $this->form_validation->set_rules('date', 'date', 'required');
            $this->form_validation->set_rules('product_id[]', 'product_id', 'required');
            $this->form_validation->set_rules('price[]', 'price', 'required');
            $this->form_validation->set_rules('quantity[]', 'quantity', 'required');
            $this->form_validation->set_rules('totalprice[]', 'totalprice', 'required');
            if ($this->form_validation->run() == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/purchase_selected2/'));
            } else {
                $post = $this->input->post();
                $sale = array();
                $sale['customber_id'] = $post['customber_id'];
                $sale['date'] = $post['date'];
                $sale['total_amount'] = $post['subtotal'];
                $sale['total_pcs'] = $post['totalquantity'];

                $this->db->insert('sales', $sale);
                $sale_id = $this->db->insert_id();

                $sale_details = $new = array();
                for ($i = 0; $i < count($post['product_id']); $i++) {
                    $sale_details['product_id'] = $post['product_id'][$i];
                    $sale_details['price'] = $post['price'][$i];
                    $sale_details['total_price'] = $post['totalprice'][$i];
                    $sale_details['qty'] = $post['quantity'][$i];
                    $sale_details['sales_id'] = $sale_id;
                    $new[] = $sale_details;
                }

                $this->db->insert_batch('sales_details', $new);

                $message = ['class' => 'success my-3', 'message' => 'purchase product Added Successfully !!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/purchase_selected2/report'));
            }
        }
        if ($params == "edit") {
            $query = $this->db->get_where('sales', ['id' => $id]);
            if ($query->num_rows() == 1) {

                $this->db->select('S.customber_id,S.date,S.total_amount,S.total_pcs, SD.*,SD.id as sdid');
                $this->db->from('sales_details as SD');
                $this->db->join('sales as S', 'S.id = SD.sales_id', 'left');
                $this->db->where('S.id', $id);
                $data = $this->db->get()->result_array();

                $page_data['page_title'] = "Purchase_selected_edit  Report";
                $page_data['page_name'] = "admin/purchase_selected2_edit";
                $page_data['update_data'] =  $data;
                $page_data['id'] =  $id;

                $this->load->view('admin/common', $page_data);
            } else {
                $message = ['class' => 'danger my-3', 'message' => 'purchase does not exist'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/purchase_selected2'));
            }
        }
        if ($params == "delete") {
            $id = $params1;
            $query = $this->db->get_where('sales', ['id' => $id]);
            if ($query->num_rows() > 0) {

                $this->db->where('id', $id)->delete('sales');
                $this->db->where('sales_id', $id)->delete('sales_details');
                $message = ['class' => 'success my-3', 'message' => 'purchase product deleted successfully!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/purchase_selected2/report'));
            } else {
                $message = ['class' => 'danger my-3', 'message' => 'purchase product  not deleted!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/purchase_selected2/report'));
            }
        }
        if ($params == "update") {

            $this->form_validation->set_rules('date', 'date', 'required');
            $this->form_validation->set_rules('customber_id', 'customber_id', 'required');
            $this->form_validation->set_rules('product_id[]', 'product_id', 'required');
            $this->form_validation->set_rules('price[]', 'price', 'required');
            $this->form_validation->set_rules('quantity[]', 'quantity', 'required');
            $this->form_validation->set_rules('totalprice[]', 'totalprice', 'required');
            if ($this->form_validation->run() == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/purchase_selected2/report'));
            } else {


                $id = $this->input->post('id');
                $post = $this->input->post();
                $sdid = $post['sdid'];

                $deleteQ = $this->db->get_where('sales_details', array('sales_id' => $id))->result_array();
                foreach ($deleteQ as $delR) {
                    if (!in_array($delR['id'], $sdid)) {
                        $this->db->where('id', $delR['id']);
                        $this->db->delete('sales_details');
                    }
                }
                
                $sale = array();
                $sale['customber_id'] = $post['customber_id'];
                $sale['date'] = $post['date'];
                $sale['total_amount'] = $post['subtotal'];
                $sale['total_pcs'] = $post['totalquantity'];

                $this->db->where('id', $id)->update('sales', $sale);



                for ($i = 0; $i < count($post['product_id']); $i++) {

                    if ($post['sdid'][$i] > 0) {

                        $sale_details  = array();
                        $sale_details['product_id'] = $post['product_id'][$i];
                        $sale_details['price'] = $post['price'][$i];
                        $sale_details['total_price'] = $post['totalprice'][$i];
                        $sale_details['qty'] = $post['quantity'][$i];
                        $sale_details['sales_id'] = $id;
                        $sale_details['id'] = $post['sdid'][$i];
                        $new[] = $sale_details;
                        $query = $this->db->get_where('sales_details', ['id' => $post['sdid'][$i]]);

                        if ($query->num_rows() == 1) {
                            $this->db->where(['sales_id' => $id, 'id' => $post['sdid'][$i]])->update('sales_details', $sale_details);
                            $message = ['class' => 'success my-3', 'message' => 'purchase product updated successfully!'];
                            $this->session->set_flashdata('flash', $message);
                        } else {
                            $message = ['class' => 'danger my-3', 'message' => 'purchase product does not updated'];
                            $this->session->set_flashdata('flash', $message);
                        }
                    } else if ($post['sdid'][$i] == 0) {
                        $sale_detail = array();
                        $sale_detail['product_id'] = $post['product_id'][$i];
                        $sale_detail['price'] = $post['price'][$i];
                        $sale_detail['total_price'] = $post['totalprice'][$i];
                        $sale_detail['qty'] = $post['quantity'][$i];
                        $sale_detail['sales_id'] = $id;


                        $this->db->insert('sales_details', $sale_detail);
                        $message = ['class' => 'success my-3', 'message' => 'purchase product updated successfully!'];
                        $this->session->set_flashdata('flash', $message);
                    }
                }



                redirect(base_url('admin/purchase_selected2/report'));
            }
        }
    }

    public function report()
    {
        $data['page_title'] = "Purchase_selected  Report | Admin";
        $data['page_name'] = "admin/purchase_selected2_report";
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
            $searchQuery = " (id like '%" . $searchValue . "%'  or customber.name like '%" . $searchValue . "%'  or total_pcs like '%" . $searchValue . "%' or total_amount like'%" . $searchValue . "%') ";
        }
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $records = $this->db->get('sales')->result();
        $totalRecords = $records[0]->allcount;


        ## Total number of record with filtering

        $this->db->select('sales.*, customber.name as cname');
        $this->db->from('sales');
        $this->db->join('customber', 'customber.cid = sales.customber_id', 'left');

        if ($searchQuery != '')
            $this->db->where($searchQuery);
        if (!empty($customber_id)) {
            $this->db->where('sales.customber_id', $customber_id);
        }
        if (!empty($fromdate)) {
            $this->db->where('DATE(sales.date) >=', $fromdate);
        }
        if (!empty($todate)) {
            $this->db->where('DATE(sales.date) <=', $todate);
        }
        $sales = $this->db->get();
        $totalRecordwithFilter = $sales->num_rows();


        ## Fetch records
        $this->db->select('sales.*, customber.name as cname');
        $this->db->from('sales');
        $this->db->join('customber', 'customber.cid = sales.customber_id', 'left');

        if ($searchQuery != '')
            $this->db->where($searchQuery);
        if (!empty($customber_id)) {
            $this->db->where('sales.customber_id', $customber_id);
        }
        if (!empty($fromdate)) {
            $this->db->where('DATE(sales.date) >=', $fromdate);
        }
        if (!empty($todate)) {
            $this->db->where('DATE(sales.date) <=', $todate);
        }
        $this->db->limit($rowperpage, $start);
        $sales = $this->db->get()->result();


        $data = array();
        $i = $start + 1;
        foreach ($sales as $record) {

            $this->db->select('sales_details.*,product.name as pname');
            $this->db->from('sales_details');
            $this->db->join('product', 'product.id = sales_details.product_id', 'left');
            $this->db->where('sales_id', $record->id);
            $sales_details = $this->db->get()->result_array();

            $producthtml = "";
            $pricehtml = "";
            $quantiryhtml = "";
            $totalpricehtml = "";
            foreach ($sales_details as $rows) {
                $producthtml .= $rows['pname'] . "</br>";
                $pricehtml .= $rows['price'] . "</br>";
                $quantiryhtml .= $rows['qty'] . "</br>";
                $totalpricehtml .= $rows['total_price'] . "</br>";
            }

            $action = '
        <a href="index/edit/' . $record->id . '" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i>Edit</a>
        <a href="index/delete/' . $record->id . '" class="btn btn-danger del" ><i class="fa-solid fa-trash"></i>Delete</a>    
        ';

            $data[] = array(
                'id' => $i,
                'sales_id' => $record->id,
                'date' => $record->date,
                'product' => $producthtml,
                'price' => $pricehtml,
                'quantity' =>  $quantiryhtml,
                'total_price' => $totalpricehtml,
                'total_pcs' => $record->total_pcs,
                'customber' => $record->cname,
                'total_amount' => $record->total_amount,
                'created_at' => $record->created_at,
                'updated_at' => $record->updated_at,
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
}
