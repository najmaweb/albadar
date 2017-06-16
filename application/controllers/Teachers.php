<?php
class Teachers extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
    function index(){
        $data = array(
            "breadcrumb" => array(1=>"Guru",2=>"Daftar"),
            "formtitle"=>"Daftar Guru",
            "feedData"=>"subject"
        );
        $this->load->view("teachers/teachers",$data);
    }
}