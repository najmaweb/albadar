<?php
class Companies extends CI_Controller{
    var $theme;
    var $cname;
    function __construct(){
        parent::__construct();
        $this->load->model("User");
        $this->theme = $this->config->item("theme");
        $this->cname = "companies";
    }
    function index(){
        session_start();
        checklogin();
        $obj = new Company();
        $data = array(
            "breadcrumb" => array(1=>"Company",2=>"Daftar"),
            "cname"=>$this->cname,
            "formtitle"=>"Daftar Perusahaan",
            "feedData"=>"company",
            "objs"=>$obj->gets(),
            "parent"=>$this->cname,
            "role"=>$this->User->getrole($_SESSION["userid"]),
            "title"=>"Perusahaan",
        );
        $this->load->view($this->cname."/".$this->theme."/companies",$data);
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
        $obj = new Company($this->uri->segment(3));
        $data = array(
            "breadcrumb" => array(1=>"Perusahaan",2=>"Edit"),
            "companies"=>$company->getcombodata(),
            "formtitle"=>"Edit Perusahaan",
            "feedData"=>"company",
            "title"=>"Edit Perusahaan",
            "obj"=>$obj->get(),
            "parent"=>$this->cname,
            "role"=>"1",
            "title"=>$this->cname
        );
        $this->load->view($this->cname."/".$this->theme."/edit",$data);        
    }
    function save(){
        $params = $this->input->post();
        $obj = new Company();
        if($obj->save($params)){
            redirect("/".$this->cname);
        }
    }
    function update(){
        $params = $this->input->post();
        $obj = new Company();
        if($obj->update($params)){
            redirect("/".$this->cname);
        }
    }
}