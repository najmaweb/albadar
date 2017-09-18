<?php
class Company extends CI_Model{
    var $id;
    function __construct($id = null){
        parent::__construct();
        $this->id = $id;
    }
    function getCompanies(){
        $sql = "select * from companies ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function getCompany(){
        $sql = "select * from companies ";
        $sql.= "where id=".$this->id."";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result()[0];
    }
}