<?php
class Bimbelgroups extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("Bimbelgroup");
    }
    function index(){
        $data = array(
            "breadcrumb" => array(1=>"Grup Biaya Bimbel",2=>"Daftar"),
            "formtitle"=>"Daftar Grup Biaya Bimbel",
            "feedData"=>"bimbelgroup",
            "objs" => $this->Bimbelgroup->getbimbelgroups()
        );
        $this->load->view("bimbelgroups/bimbelgroup",$data);
    }
    function add(){
        $data = array(
            "breadcrumb" => array(1=>"Grup Biaya Bimbel",2=>"Penambahan"),
            "formtitle"=>"Penambahan Grup Bimbel",
            "feedData"=>"bimbelgroup",
            "bimbelgroups"=>$this->Bimbelgroup->getbimbelgroups()
        );
        $this->load->view("bimbelgroups/add",$data);        
    }
    function edit(){
        $data = array(
            "breadcrumb" => array(1=>"Grup SPP",2=>"Edit"),
            "formtitle"=>"Edit Grup Bimbel",
            "feedData"=>"bimbelgroup",
            "obj"=>$this->Bimbelgroup->getbimbelgroup($this->uri->segment(3))
        );
        $this->load->view("bimbelgroups/edit",$data);        
    }
    function remove(){
        $id = $this->uri->segment(3);
        $this->Bimbelgroup->remove($id);
        redirect("../../");
    }
    function save(){
        $params = $this->input->post();
        $this->Bimbelgroup->save($params);
        redirect("../index");
    }
    function update(){
        $params = $this->input->post();
        echo $this->Bimbelgroup->update($params);
        redirect("../index");
    }
}