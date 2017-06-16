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
}