<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Crud extends CI_Controller {
    //functions
    function index(){
        $data["title"] = "Modify Profile";
        $this->load->view('crud_view', $data);
    }
    function fetch_user(){
        $this->load->model("crud_model");
        $fetch_data = $this->crud_model->make_datatables();
        $data = array();
        foreach($fetch_data as $row)
        {
            $sub_array = array();
            $sub_array[] = $row->username;
            $sub_array[] = $row->email;
            $sub_array[] = $row->admin;
            $sub_array[] = '<button type="button" name="update" id="'.$row->id.'" class="btn btn-warning btn-xs update">Update</button>';
            $data[] = $sub_array;
        }
        $output = array(
            "draw"                    =>     intval($_POST["draw"]),
            "recordsTotal"          =>      $this->crud_model->get_all_data(),
            "recordsFiltered"     =>     $this->crud_model->get_filtered_data(),
            "data"                    =>     $data
        );
        echo json_encode($output);
    }
    function user_action(){
        if($_POST["action"] == "Edit")
        {
            $updated_data = array(
                'username'          =>     $this->input->post('username'),
                'email'             =>     $this->input->post('email'),
                'admin'             =>     $this->input->post('admin'),
            );
            $this->load->model('crud_model');
            $this->crud_model->update_crud($this->input->post("user_id"), $updated_data);
            echo 'Data Updated';
        }
    }
    function fetch_single_user()
    {
        $output = array();
        $this->load->model("crud_model");
        $data = $this->crud_model->fetch_single_user($_POST["user_id"]);
        foreach($data as $row)
        {
            $output['username'] = $row->username;
            $output['email'] = $row->email;
            $output['admin'] = $row->admin;
        }
        echo json_encode($output);
    }
}