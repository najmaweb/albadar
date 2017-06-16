<?php
class Sppgroups extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("Sppgroup");
    }
    function index(){
        $data = array(
            "breadcrumb" => array(1=>"Grup SPP",2=>"Daftar"),
            "formtitle"=>"Daftar Grup SPP",
            "feedData"=>"sppgroup",
            "objs" => $this->Sppgroup->getsppgroups()
        );
        $this->load->view("sppgroups/sppgroup",$data);
    }
    function add(){
        $data = array(
            "breadcrumb" => array(1=>"Grup SPP",2=>"Penambahan"),
            "formtitle"=>"Penambahan Grup SPP",
            "feedData"=>"sppgroup",
            "sppgroups"=>$this->Sppgroup->getsppgroups()
        );
        $this->load->view("sppgroups/add",$data);        
    }
    function edit(){
        $data = array(
            "breadcrumb" => array(1=>"Grup SPP",2=>"Edit"),
            "formtitle"=>"Edit Grup SPP",
            "feedData"=>"sppgroup",
            "obj"=>$this->Sppgroup->getsppgroup($this->uri->segment(3))
        );
        $this->load->view("sppgroups/edit",$data);        
    }
    function remove(){
        $id = $this->uri->segment(3);
        $this->Sppgroup->remove($id);
        redirect("../../");
    }
    function save(){
        $params = $this->input->post();
        $this->Sppgroup->save($params);
        redirect("../index");
    }
    function update(){
        $params = $this->input->post();
        echo $this->Sppgroup->update($params);
        redirect("../index");
    }
}