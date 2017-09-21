<?php
class Shifts extends CI_Controller{
    var $theme;
    var $cname;
    function __construct(){
        parent::__construct();
        $this->load->model("User");
        $this->theme = $this->config->item("theme");
        $this->cname = "shifts";
    }
    function index(){
        session_start();
        checklogin();
        $obj = new Shift();
        $data = array(
            "breadcrumb" => array(1=>"Shift",2=>"Daftar"),
            "cname"=>$this->cname,
            "formtitle"=>"Daftar Shift",
            "feedData"=>"shift",
            "objs"=>$obj->gets(),
            "parent"=>$this->cname,
            "role"=>$this->User->getrole($_SESSION["userid"]),
            "title"=>"Shift",
        );
        $this->load->view($this->cname."/".$this->theme."/shifts",$data);
    }
    function add(){
        session_start();
        checklogin();
        $shift = new Shift();
        $data = array(
            "breadcrumb" => array(1=>"Shift",2=>"Penambahan"),
            "formtitle"=>"Penambahan Shift",
            "feedData"=>$this->cname,
            "companies"=>$shift->getcombodata("Pilihlah"),
            "parent"=>$this->cname,
            "role"=>1,
            "title"=>$this->cname,
        );
        $this->load->view($this->cname."/".$this->theme."/add",$data);        
    }
    function edit(){
        session_start();
        checklogin();
        $shift = new Shift();
        $obj = new Shift($this->uri->segment(3));
        $data = array(
            "breadcrumb" => array(1=>"Shift",2=>"Edit"),
            "companies"=>$shift->getcombodata(),
            "formtitle"=>"Edit Shift",
            "feedData"=>"shift",
            "title"=>"Edit Shift",
            "obj"=>$obj->get(),
            "parent"=>$this->cname,
            "role"=>"1",
            "title"=>$this->cname
        );
        $this->load->view($this->cname."/".$this->theme."/edit",$data);        
    }
    function save(){
        $params = $this->input->post();
        $obj = new Shift();
        if($obj->save($params)){
            redirect("/".$this->cname);
        }
    }
    function update(){
        $params = $this->input->post();
        $obj = new Shift();
        if($obj->update($params)){
            redirect("/".$this->cname);
        }
    }
}