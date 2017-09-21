<?php
class Shift extends CI_Model{
    var $id;
    var $tablename;
    function __construct($id = null){
        parent::__construct();
        $this->id = $id;
        $this->tablename = "shifts";
    }
    function gets(){
        $sql = "select * from ".$this->tablename." ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function get(){
        $sql = "select * from ".$this->tablename." ";
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
        $sql = "select id,name from ".$this->tablename." ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        foreach($que->result() as $res){
            $arr[$res->id] = $res->name;
        }
        return $arr;        
    }
    function save($params){
        $keys = array();$vals = array();
        foreach($params as $key=>$val){
            array_push($keys,$key);
            array_push($vals,$val);
        }
        $sql = "insert into " . $this->tablename . " ";
        $sql.= " (".implode(",",$keys).") ";
        $sql.= "values ";
        $sql.= " ('".implode("','",$vals)."') ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $ci->db->insert_id();
    }
    function update($params){
        $arr = array();
        foreach($params as $key=>$val){
            array_push($arr,"".$key."='".$val."'");
        }
        $sql = "update " . $this->tablename . " ";
        $sql.= " set ".implode(",",$arr)." ";
        $sql.= " where id=".$params["id"]."";
        $ci = & get_instance();
        return $que = $ci->db->query($sql);
    }
}