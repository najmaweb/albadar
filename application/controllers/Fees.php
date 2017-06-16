<?php
class Fees extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
    function index(){
        $data = array(
            "breadcrumb" => array(1=>"Siswa",2=>"Biaya Pendidikan"),
            "formtitle"=>"Biaya Pendidikan",
            "feedData"=>"fees"
        );
        $this->load->view("fees/fees",$data);
    }
}