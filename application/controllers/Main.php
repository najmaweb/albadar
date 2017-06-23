<?php
class Main extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
    function index(){
        $data = array(
            "breadcrumb" => array(1=>"Siswa",2=>"Entri Nilai"),
            "feedData"=>"evaluasi"
        );
        redirect("../cashier");
    }
    function login(){
        $this->load->view("login");
    }
    function loginhandler(){
        $params = $this->input->post();
        foreach($params as $key=>$val){
            echo $key . " and " . $val . "<br />";
        }
    }
}