<?php
class Dupsbgroups extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("Dupsbgroup");
        $this->load->model("User");
    }
    function index(){
        $data = array(
            "breadcrumb" => array(1=>"Grup Dupsb",2=>"Daftar"),
            "formtitle"=>"Daftar Grup Dupsb",
            "feedData"=>"Dupsbgroup",
            "objs" => $this->Dupsbgroup->getDupsbgroups(),
            "role"=>$this->User->getrole()
        );
        $this->load->view("dupsbgroups/dupsbgroup",$data);
    }
    function add(){
        $data = array(
            "breadcrumb" => array(1=>"Grup Dupsb",2=>"Penambahan"),
            "formtitle"=>"Penambahan Grup Dupsb",
            "feedData"=>"Dupsbgroup",
            "Dupsbgroups"=>$this->Dupsbgroup->getDupsbgroups(),
            "role"=>$this->User->getrole()
        );
        $this->load->view("dupsbgroups/add",$data);        
    }
    function edit(){
        $data = array(
            "breadcrumb" => array(1=>"Grup Dupsb",2=>"Edit"),
            "formtitle"=>"Edit Grup Dupsb",
            "feedData"=>"Dupsbgroup",
            "obj"=>$this->Dupsbgroup->getDupsbgroup($this->uri->segment(3)),
            "role"=>$this->User->getrole()
        );
        $this->load->view("dupsbgroups/edit",$data);        
    }
    function remove(){
        $id = $this->uri->segment(3);
        $this->Dupsbgroup->remove($id);
        redirect("../../");
    }
    function save(){
        $params = $this->input->post();
        $this->Dupsbgroup->save($params);
        redirect("../index");
    }
    function update(){
        $params = $this->input->post();
        echo $this->Dupsbgroup->update($params);
        redirect("../index");
    }
}