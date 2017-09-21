<?php
class Department extends CI_Model{
    var $id;
    var $tname;
    function __construct($id = null){
        parent::__construct();
        $this->id = $id;
        $this->tname = "departments";
    }
    function getarray(){
        $sql = "select id,name,description from  " . $this->tname . "  ";
        $sql.= "order by name";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        $arr = array();
        foreach($que->result() as $res){
            $arr[$res->id] = $res->name;
        }
        return $arr;
    }
    function get(){
        $sql = "select a.id,a.name,a.description,a.company_id,b.name company from  " . $this->tname . "  a ";
        $sql.= "left outer join companies b on b.id=a.company_id ";
        $sql.= "where a.id=".$this->id;
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result()[0];
    }
    function getcombodata($firstrow = "Pilihlah"){
        $sql = "select a.id,a.name,a.description,a.company_id from  " . $this->tname . "  a ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        $out = array();
        if(!is_null($firstrow)){
            $out[0] = $firstrow;
        }
        foreach($que->result() as $res){
            $out[$res->id] = $res->name;
        }
        return $out;     
    }
    function gets(){
        $sql = "select a.id,a.name,a.description,b.name company  from  " . $this->tname . "  a ";
        $sql.= "left outer join companies b on b.id=a.company_id ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function remove($id){
        $sql = "delete from  " . $this->tname . "  where id=".$id;
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $sql;
    }
    function save($params){
        $keys = array();$vals = array();
        foreach($params as $key=>$val){
            array_push($keys,$key);
            array_push($vals,$val);
        }
        $sql = "insert into " . $this->tname . "  (".implode(",",$keys).") ";
        $sql.= "values ";
        $sql.= "('".implode("','",$vals)."') ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $ci->db->insert_id();
    }
    function update($params){
        $arr = array();
        foreach($params as $key=>$val){
            array_push($arr,"".$key."='".$val."'");
        }
        $sql = "update " . $this->tname . " set " . implode(",",$arr) . " ";
        $sql.= "where ";
        $sql.= "id='".$params['id']."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $sql;
    }    
}