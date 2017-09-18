<?php
class Departments extends CI_Controller{
    var $theme;
    function __construct(){
        parent::__construct();
        $this->load->model("User");
        $this->theme = $this->config->item("theme");
    }
    function index(){
        session_start();
        checklogin();
        $obj = new Department();
        $data = array(
            "breadcrumb" => array(1=>"Department",2=>"Daftar"),
            "formtitle"=>"Daftar Department",
            "feedData"=>"department",
            "objs"=>$obj->gets(),
            "parent"=>"departments",
            "role"=>$this->User->getrole($_SESSION["userid"]),
            "title"=>"Departments",
        );
        $this->load->view("departments/".$this->theme."/departments",$data);
    }
    function add(){
        session_start();
        checklogin();
        $data = array(
            "breadcrumb" => array(1=>"Pegawai",2=>"Penambahan"),
            "formtitle"=>"Penambahan Pegawai",
            "feedData"=>"departments",
            "objs"=>$this->employee->getemployees(),
            "role"=>$this->employee->getrole($_SESSION["employeeid"])
        );
        $this->load->view("departments/add",$data);        
    }
    function edit(){
        session_start();
        checklogin();
        $obj = new Department($this->uri->segment(3));
        $data = array(
            "breadcrumb" => array(1=>"Department",2=>"Edit"),
            "formtitle"=>"Edit Department",
            "feedData"=>"department",
            "title"=>"Edit Department",
            "obj"=>$obj->get(),
            "parent"=>"departments",
            "role"=>"1",
            "roles"=>'["Programmer","IT Manager","IT Supervisor","IT Staff","Full Stack Developer"]',
            "departments"=>'["IT","Accounting","Purchasing","Marketing"]',
        );
        $this->load->view("departments/".$this->theme."/edit",$data);        
    }
}