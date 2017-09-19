<?php
class Company extends CI_Model{
    var $id;
    function __construct($id = null){
        parent::__construct();
        $this->id = $id;
    }
    function gets(){
        $sql = "select * from companies ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function get(){
        $sql = "select * from companies ";
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
        $sql = "select id,name from companies ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        foreach($que->result() as $res){
            $arr[$res->id] = $res->name;
        }
        return $arr;        
    }
}