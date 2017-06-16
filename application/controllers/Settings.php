<?php
class Settings extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("Setting");
    }
    function getyear(){
        $sql = "select currentyear from settings ";
        $que = $this->db->query($sql);
        $res = $que->result();
        return $res[0];
    }
    function index(){
        $data = array(
            "breadcrumb" => array(1=>"App",2=>"Setting"),
            "formtitle"=>"Setting",
            "feedData"=>"settings",
            "currentyear"=>$this->Setting->getcurrentyear()
        );
        $this->load->view("commons/settings",$data);
    }
    function save(){
        $params = $this->input->post();
        $this->Setting->update($params);
        redirect("../index");
    }
}