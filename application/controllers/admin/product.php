<?php

defined('BASEPATH') or exit('No direct script access allowed');

class product extends CI_Controller
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



            $data['page_title'] = "product | Admin";
            $data['page_name'] = "admin/product";
            //$data['data'] =  $result;
            $this->load->view('admin/common', $data);
        }
        if ($params == "add") {
            $config = [
                'upload_path' => './upload',
                'allowed_types' => 'gif|jpg|png|jpeg',
            ];
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->form_validation->set_rules('title', 'title', 'required');
            $this->form_validation->set_rules('category_id', 'category_id', 'required');
            $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required');
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('price', 'price', 'required');
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('productimage', 'productimage', 'required');

            if ($this->form_validation->run() == FALSE && $this->upload->do_upload('productimage') == FALSE) {
                $message = ['class' => 'danger', 'message' => validation_errors()];
                $message = ['class' => 'danger my-3', 'message' => 'product  not Added Successfully !!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/product'));
            } else {
                $title = $this->input->post('title');
                $product = $this->input->post('name');
                $price = $this->input->post('price');
                $category = $this->input->post('category_id');
                $subcategory = $this->input->post('subcategory_id');
                $description = $this->input->post('description');
                $productimage = $this->upload->data();

                $productimage = $productimage['file_name'];

                $this->db->insert('product', ['title' => $title, 'name' => $product, 'price' => $price, 'category_id' => $category, 'subcategory_id' => $subcategory,  'description' => $description, 'productimage' => $productimage]);
                $message = ['class' => 'success my-3', 'message' => 'product Added Successfully !!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/product'));
            }
        }

        if ($params == "edit") {

            $query = $this->db->get_where('product', ['id' => $id]);
            if ($query->num_rows() == 1) {
                $page_data['page_title'] = "Edit product ";
                $page_data['page_name'] = "admin/product";
                $page_data['update_data'] = $this->db->get_where('product', ['id' => $id])->row_array();
                $page_data['data'] = $this->db->select('P.*,C.name as category,SC.name as subcategory')
                    ->join('category C', 'C.id = P.category_id', "left")
                    ->join('subcategory SC', 'SC.id = P.subcategory_id', "left")
                    ->get('product P')->result_array();


                $this->load->view('admin/common', $page_data);
            } else {
                $message = ['class' => 'danger my-3', 'message' => 'product does not exist'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/product'));
            }
        }
        if ($params == "delete") {

            $query = $this->db->get_where('product', ['id' => $id]);
            if ($query->num_rows() > 0) {
                // product delete in folder image delete
                $product = $query->row();
                if ($product->productimage) {
                    if (file_exists('upload/' . $product->productimage)) {
                        unlink('upload/' . $product->productimage);
                    }
                }
                $this->db->where('id', $id)->delete('product');
                $message = ['class' => 'success my-3', 'message' => 'product deleted successfully!'];
            } else {
                $message = ['class' => 'success my-3', 'message' => 'product  not deleted!'];
            }
            $this->session->set_flashdata('flash', $message);
            redirect(base_url('admin/product'));
        }
        if ($params == "update") {

            $id = $this->input->post('id');
            $title = $this->input->post('title');
            $product = $this->input->post('name');
            $price = $this->input->post('price');
            $category = $this->input->post('category_id');
            $subcategory = $this->input->post('subcategory_id');
            $description = $this->input->post('description');

            $query = $this->db->get_where('product', ['id' => $id]);

            if ($_FILES['productimage']['name'] != "") {
                $config = [
                    'upload_path' => './upload',
                    'allowed_types' => 'gif|jpg|png|jpeg'
                ];

                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('productimage')) {
                    $message = ['class' => 'danger', 'message' => validation_errors()];
                    $this->session->set_flashdata('flash', $message);
                    redirect(base_url('admin/product'));
                } else {
                    $products = $query->row();
                    if ($products->productimage) {
                        if (file_exists('upload/' . $products->productimage)) {
                            unlink('upload/' . $products->productimage);
                        }
                    }
                    $productimage = $this->upload->data();

                    $productimage = $productimage['file_name'];

                    $this->db->where('id', $id)->update('product', ['productimage' => $productimage]);
                }
            }
            if ($query->num_rows() == 1) {
                $this->db->where('id', $id)->update('product', ['title' => $title, 'name' => $product, 'price' => $price, 'category_id' => $category, 'subcategory_id' => $subcategory, 'description' => $description]);
                $message = ['class' => 'success my-3', 'message' => 'product updated successfully!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/product'));
            } else {
                $message = ['class' => 'danger my-3', 'message' => 'product  not updated Successfully !!'];
                $this->session->set_flashdata('flash', $message);
                redirect(base_url('admin/product'));
            }
        }
    }

    public function getsubcategory()
    {
        $post = $this->input->post();
        if (isset($post['id'])) {
            $id = $post['id'];
            $sub = $this->db->where('category_id', $id)->get('subcategory')->result_array();
            $html = "";
            foreach ($sub as $row) {
                $html .= "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            echo json_encode(array("html" => $html, "status" => true));
        }
    }

    public function getlist()
    {
        $postData = $this->security->xss_clean($this->input->post());
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length'];
        $columnIndex = $postData['order'][0]['column']; // Column index
        $searchValue = $postData['search']['value']; // Search value
        $category_id = $postData['category'];
        # Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = " (title like '%" . $searchValue . " %' or product.name like '%" . $searchValue . "%' or category.name like '%" . $searchValue . "%' or subcategory.name like '%" . $searchValue . "%' or description like'%" . $searchValue . "%') ";
        }
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $records = $this->db->get('product')->result();
        $totalRecords = $records[0]->allcount;


        ## Total number of record with filtering
        $this->db->select('product.*,category.name as cname,subcategory.name as scname');
        $this->db->from('product');
        $this->db->join('category', 'category.id = product.category_id', 'left');
        $this->db->join('subcategory', 'subcategory.id = product.subcategory_id', 'left');

        if ($searchQuery != '')
            $this->db->where($searchQuery);

        if (!empty($category_id)) {
            $this->db->where('product.category_id', $category_id);
        }

        $records = $this->db->get();
        $totalRecordwithFilter = $records->num_rows();


        ## Fetch records

        $this->db->select('product.*,category.name as cname,subcategory.name as scname');
        $this->db->from('product');
        $this->db->join('category', 'category.id = product.category_id', 'left');
        $this->db->join('subcategory', 'subcategory.id = product.subcategory_id', 'left');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        if (!empty($category_id)) {
            $this->db->where('product.category_id', $category_id);
        }
        //$this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();


        $data = array();
        $i = $start + 1;
        foreach ($records as $record) {
            $action = '
            <a href="product/index/edit/' . $record->id . '" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i>Edit</a>
            <a href="product/index/delete/' . $record->id . '" class="btn btn-danger" id=""delete><i class="fa-solid fa-trash"></i>Delete</a>
            ';
            $data[] = array(
                'id' => $i,
                'title' => $record->title,
                'name' => $record->name,
                'price' => $record->price,
                'category' => $record->cname,
                'subcategory' =>  $record->scname,
                'description' => $record->description,
                'productimage' => $record->productimage,
                'created_at' => $record->created_at,
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
