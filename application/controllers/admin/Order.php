<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
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
            $data['page_title'] = "order";
            $data['page_name'] = 'admin/order';
            $this->load->view('admin/common', $data);
        }


        if ($params == "add") {

            $this->form_validation->set_rules('customer_id', 'customer_id', 'required');
            $this->form_validation->set_rules('number', 'number', 'required');
            $this->form_validation->set_rules('date', 'date', 'required');
            $this->form_validation->set_rules('product_id[]', 'product_id', 'required');
            $this->form_validation->set_rules('price[]', 'price', 'required');
            $this->form_validation->set_rules('quantity[]', 'quantity', 'required');
            $this->form_validation->set_rules('totalprice[]', 'totalprice', 'required');
            if ($this->form_validation->run() == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/Order/'));
            } else {
                $post = $this->input->post();
                $order = array();
                $order['customer_id'] = $post['customer_id'];
                $order['date'] = $post['date'];
                $order['number'] = $post['number'];
                $order['total_amount'] = $post['subtotal'];
                $order['total_quantity'] = $post['totalquantity'];

                $this->db->insert('order', $order);
                $order_id = $this->db->insert_id();

                $order_details = $new = array();
                for ($i = 0; $i < count($post['product_id']); $i++) {
                    $order_details['product_id'] = $post['product_id'][$i];
                    $order_details['price'] = $post['price'][$i];
                    $order_details['total_price'] = $post['totalprice'][$i];
                    $order_details['quantity'] = $post['quantity'][$i];
                    $order_details['order_id'] = $order_id;
                    $new[] = $order_details;
                }

                $this->db->insert_batch('order_details', $new);

                $message = ['class' => 'success my-3', 'message' => 'order Successfully !!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/order/report'));
            }
        }

        if ($params == "edit") {
            $query = $this->db->get_where('order', ['id' => $id]);
            if ($query->num_rows() == 1) {

                $this->db->select('o.customer_id,o.number,o.date,o.total_amount,o.total_quantity, od.*,od.id as odid');
                $this->db->from('order_details as od');
                $this->db->join('order as o', 'o.id = od.order_id', 'left');
                $this->db->where('o.id', $id);
                $data = $this->db->get()->result_array();

                $page_data['page_title'] = "Order  Edit";
                $page_data['page_name'] = "admin/order_edit";
                $page_data['update_data'] =  $data;
                $page_data['id'] =  $id;

                $this->load->view('admin/common', $page_data);
            } else {
                $message = ['class' => 'danger my-3', 'message' => 'order does not exist'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/Order'));
            }
        }
        if ($params == "delete") {

            $record_id = $this->input->post('id');
            $this->db->where('id', $record_id)->delete('order');
            $this->db->where('order_id', $record_id)->delete('order_details');

            $result = $this->db->affected_rows() > 0;
        }
        if ($params == "update") {

            $this->form_validation->set_rules('date', 'date', 'required');
            $this->form_validation->set_rules('customer_id', 'customer_id', 'required');
            $this->form_validation->set_rules('number', 'number', 'required');
            $this->form_validation->set_rules('product_id[]', 'product_id', 'required');
            $this->form_validation->set_rules('price[]', 'price', 'required');
            $this->form_validation->set_rules('quantity[]', 'quantity', 'required');
            $this->form_validation->set_rules('totalprice[]', 'totalprice', 'required');
            if ($this->form_validation->run() == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/Order/report'));
            } else {

                $id = $this->input->post('id');
                $post = $this->input->post();
                $odid = $post['odid'];

                $deleteQ = $this->db->get_where('order_details', array('order_id' => $id))->result_array();
                foreach ($deleteQ as $delR) {
                    if (!in_array($delR['id'], $odid)) {
                        $this->db->where('id', $delR['id']);
                        $this->db->delete('order_details');
                    }
                }

                $order = array();
                $order['customer_id'] = $post['customer_id'];
                $order['number'] = $post['number'];
                $order['date'] = $post['date'];
                $order['total_amount'] = $post['subtotal'];
                $order['total_quantity'] = $post['totalquantity'];

                $this->db->where('id', $id)->update('order', $order);

                for ($i = 0; $i < count($post['product_id']); $i++) {

                    if ($post['odid'][$i] > 0) {

                        $order_details  = array();
                        $order_details['product_id'] = $post['product_id'][$i];
                        $order_details['price'] = $post['price'][$i];
                        $order_details['total_price'] = $post['totalprice'][$i];
                        $order_details['quantity'] = $post['quantity'][$i];
                        $order_details['order_id'] = $id;
                        $order_details['id'] = $post['odid'][$i];
                        $new[] = $order_details;
                        $query = $this->db->get_where('order_details', ['id' => $post['odid'][$i]]);

                        if ($query->num_rows() == 1) {
                            $this->db->where(['order_id' => $id, 'id' => $post['odid'][$i]])->update('order_details', $order_details);
                            $message = ['class' => 'success my-3', 'message' => 'Order updated successfully!'];
                            $this->session->set_flashdata('flash', $message);
                        } else {
                            $message = ['class' => 'danger my-3', 'message' => 'Order does not updated'];
                            $this->session->set_flashdata('flash', $message);
                        }
                    } else if ($post['odid'][$i] == 0) {
                        $order_detail = array();
                        $order_detail['product_id'] = $post['product_id'][$i];
                        $order_detail['price'] = $post['price'][$i];
                        $order_detail['total_price'] = $post['totalprice'][$i];
                        $order_detail['quantity'] = $post['quantity'][$i];
                        $order_detail['order_id'] = $id;


                        $this->db->insert('order_details', $order_detail);
                        $message = ['class' => 'success my-3', 'message' => 'Order updated successfully!'];
                        $this->session->set_flashdata('flash', $message);
                    }
                }

                redirect(base_url('admin/Order/report'));
            }
        }
    }

    public function report()
    {
        $data['page_title'] = "Order Report | Admin";
        $data['page_name'] = "admin/order_report";
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
        $customer_id = $postData['customer'];
        $todate = $postData['todate'];
        $fromdate = $postData['fromdate'];

        # Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = " (id like '%" . $searchValue . "%'  or customber.number like '%" . $searchValue . "%' or customber.name like '%" . $searchValue . "%' or total_quantity like '%" . $searchValue . "%' or total_amount like'%" . $searchValue . "%') ";
        }
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $records = $this->db->get('order')->result();
        $totalRecords = $records[0]->allcount;


        ## Total number of record with filtering

        $this->db->select('order.*, customber.name as cname');
        $this->db->from('order');
        $this->db->join('customber', 'customber.cid = order.customer_id', 'left');

        if ($searchQuery != '')
            $this->db->where($searchQuery);
        if (!empty($customer_id)) {
            $this->db->where('order.customer_id', $customer_id);
        }
        if (!empty($fromdate)) {
            $this->db->where('DATE(order.date) >=', $fromdate);
        }
        if (!empty($todate)) {
            $this->db->where('DATE(order.date) <=', $todate);
        }
        $sales = $this->db->get();
        $totalRecordwithFilter = $sales->num_rows();


        ## Fetch records
        $this->db->select('order.*, customber.name as cname');
        $this->db->from('order');
        $this->db->join('customber', 'customber.cid = order.customer_id', 'left');

        if ($searchQuery != '')
            $this->db->where($searchQuery);
        if (!empty($customer_id)) {
            $this->db->where('order.customer_id', $customer_id);
        }
        if (!empty($fromdate)) {
            $this->db->where('DATE(order.date) >=', $fromdate);
        }
        if (!empty($todate)) {
            $this->db->where('DATE(order.date) <=', $todate);
        }
        $this->db->limit($rowperpage, $start);
        $sales = $this->db->get()->result();


        $data = array();
        $i = $start + 1;
        foreach ($sales as $record) {

            $this->db->select('order_details.*,product.name as pname');
            $this->db->from('order_details');
            $this->db->join('product', 'product.id = order_details.product_id', 'left');
            $this->db->where('order_id', $record->id);
            $order_details = $this->db->get()->result_array();

            $producthtml = "";
            $pricehtml = "";
            $quantityhtml = "";
            $totalpricehtml = "";
            foreach ($order_details as $rows) {
                $producthtml .= $rows['pname'] . "</br>";
                $pricehtml .= $rows['price'] . "</br>";
                $quantityhtml .= $rows['quantity'] . "</br>";
                $totalpricehtml .= $rows['total_price'] . "</br>";
            }

            $action = '
        <a href="index/edit/' . $record->id . '" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i>Edit</a>
        <a data-id="' . $record->id . '" class="btn btn-danger deleterecord" ><i class="fa-solid fa-trash"></i>Delete</a>    
        ';

            $data[] = array(
                'id' => $i,
                'order_id' => $record->id,
                'date' => $record->date,
                'product' => $producthtml,
                'price' => $pricehtml,
                'quantity' =>  $quantityhtml,
                'total_price' => $totalpricehtml,
                'total_quantity' => $record->total_quantity,
                'customer' => $record->cname,
                'number' => $record->number,
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
