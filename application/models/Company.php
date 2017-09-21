<?php
class Company extends CI_Model{
    var $tname;
    var $id;
    function __construct($id = null){
        parent::__construct();
        $this->id = $id;
        $this->tname = "companies";
    }
    function gets(){
        $sql = "select * from ".$this->tname." ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function get(){
        $sql = "select * from ".$this->tname." ";
        $sql.= "where id=".$this->id."";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result()[0];
    }
    function getcombodata($firstrow = "Pilihlah"){
        $arr = array();
        if(!is_null($firstrow)){
            $arr[0] = $firstrow;
        }
        $sql = "select id,name from ".$this->tname." ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        foreach($que->result() as $res){
            $arr[$res->id] = $res->name;
        }
        return $arr;        
    }
}