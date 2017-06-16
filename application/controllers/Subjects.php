<?php
class Subjects extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
    function index(){
        $data = array(
            "breadcrumb" => array(1=>"Mapel",2=>"Daftar"),
            "formtitle"=>"Daftar Mata Pelajaran",
            "feedData"=>"subject"
        );
        $this->load->view("students/students",$data);
    }
}