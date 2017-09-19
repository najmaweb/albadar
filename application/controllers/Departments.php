<?php
class Departments extends CI_Controller{
    var $theme;
    var $cname;
    function __construct(){
        parent::__construct();
        $this->load->model("User");
        $this->theme = $this->config->item("theme");
        $this->cname = "departments";
    }
    function index(){
        session_start();
        checklogin();
        $obj = new Department();
        $data = array(
            "breadcrumb" => array(1=>"Department",2=>"Daftar"),
            "cname"=>$this->cname,
            "formtitle"=>"Daftar Department",
            "feedData"=>"department",
            "objs"=>$obj->gets(),
            "parent"=>$this->cname,
            "role"=>$this->User->getrole($_SESSION["userid"]),
            "title"=>"Departments",
        );
        $this->load->view($this->cname."/".$this->theme."/departments",$data);
    }
    function add(){
        session_start();
        checklogin();
        $company = new Company();
        $data = array(
            "breadcrumb" => array(1=>"Pegawai",2=>"Penambahan"),
            "formtitle"=>"Penambahan Pegawai",
            "feedData"=>$this->cname,
            "companies"=>$company->getcombodata("Pilihlah"),
            "parent"=>$this->cname,
            "role"=>1,
            "title"=>$this->cname,
        );
        $this->load->view($this->cname."/".$this->theme."/add",$data);        
    }
    function edit(){
        session_start();
        checklogin();
        $company = new Company();
        $obj = new Department($this->uri->segment(3));
        $data = array(
            "breadcrumb" => array(1=>"Department",2=>"Edit"),
            "companies"=>$company->getcombodata(),
            "formtitle"=>"Edit Department",
            "feedData"=>"department",
            "title"=>"Edit Department",
            "obj"=>$obj->get(),
            "parent"=>$this->cname,
            "role"=>"1",
            "title"=>$this->cname
        );
        $this->load->view($this->cname."/".$this->theme."/edit",$data);        
    }
    function save(){
        $params = $this->input->post();
        $obj = new Department();
        if($obj->save($params)){
            redirect("/".$this->cname);
        }
    }
    function update(){
        $params = $this->input->post();
        $obj = new Department();
        if($obj->update($params)){
            redirect("/".$this->cname);
        }
    }
}