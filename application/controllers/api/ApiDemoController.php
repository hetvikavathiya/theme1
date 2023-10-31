<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use  chriskacerguis\RestServer\RestController;

class ApiDemoController extends RestController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function testing_get()
    {
        echo "hello i am testing ";
    }
    public function index_post()
    {
        // echo "i am post method   ";
        $name = $this->input->post("name");
        $email = $this->input->post("email");

        $this->form_validation->set_rules("name", "name", "required");
        $this->form_validation->set_rules("email", "email", "required|valid_email");
        if ($this->form_validation->run() == FALSE) {
            $this->response(array(
                "status" => 0,
                "message" => 'All field are needed',
            ), RestController::HTTP_NOT_FOUND);
        } else {
            if (!empty($name) && !empty($email)) {
                $data = array(
                    'name' => $name,
                    'email' => $email,

                );
                $insert = $this->db->insert('apidemocontroller', $data);
                if ($insert) {
                    $this->response(array(
                        "status" => 1,
                        "message" => 'data inserted successfully',
                    ), RestController::HTTP_OK);
                } else {
                    $this->response(array(
                        "status" => 0,
                        "message" => 'data not inserted ',
                    ), RestController::HTTP_INTERNAL_ERROR);
                }
            } else {
                $this->response(array(
                    "status" => 0,
                    "message" => 'All fields are needed',
                ), RestController::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_put()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id) && isset($data->name) && isset($data->email)) {
            $id = $data->id;
            $update_data = array(
                'name' => $data->name,
                'email' => $data->email

            );

            $this->db->where('id', $id);
            $update = $this->db->update('apidemocontroller', $update_data);
            if ($update) {
                $this->response(array(
                    "status" => 1,
                    "message" => 'data updated successfully',
                ), RestController::HTTP_OK);
            } else {
                $this->response(array(
                    "status" => 0,
                    "message" => 'failed to update data',
                ), RestController::HTTP_NOT_FOUND);
            }
        } else {
            $this->response(array(
                "status" => 0,
                "message" => 'All fields are needed',
            ), RestController::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->id;
        
        $this->db->where('id', $id);
        $delete =  $this->db->delete('apidemocontroller');
        if ($delete) {
            $this->response(array(
                'status' => 1,
                'message' => "data has been deleted"

            ), RestController::HTTP_OK);
        } else {
            $this->response(array(
                'status' => 0,
                'message' => "not deleted"

            ), RestController::HTTP_NOT_FOUND);
        }
    }

    public function index_get()
    {
        $this->db->select("*");
        $this->db->from('apidemocontroller');
        $query = $this->db->get();
        $result = $query->result();
        // echo "<pre>";
        // print_r($result);
        // echo "</pre>";
        if (count($result) > 0) {
            $this->response(array(
                "status" => 1,
                "message" => 'successfully',
                "data" => $result
            ), RestController::HTTP_OK);
        } else {
            $this->response(array(
                "status" => 0,
                "message" => 'not successfully',
                "data" => $result
            ), RestController::HTTP_NOT_FOUND);
        }
    }
}
