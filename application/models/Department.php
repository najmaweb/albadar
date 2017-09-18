<?php
class Department extends CI_Model{
    var $id;
    function __construct($id = null){
        parent::__construct();
        $this->id = $id;
    }
    function get(){
        $sql = "select a.id,a.name,a.description,b.name company from departments a ";
        $sql.= "left outer join companies b on b.id=a.company_id ";
        $sql.= "where a.id=".$this->id;
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result()[0];
    }
    function gets(){
        $sql = "select a.id,a.name,a.description,b.name company  from departments a ";
        $sql.= "left outer join companies b on b.id=a.company_id ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function getarray(){
        $sql = "select id,name,description from departments ";
        $sql.= "order by name";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        $arr = array();
        foreach($que->result() as $res){
            $arr[$res->id] = $res->name;
        }
        return $arr;
    }
    function remove($id){
        $sql = "delete from departments where id=".$id;
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
        $sql = "insert into departments (".implode(",",$keys).") ";
        $sql.= "values ";
        $sql.= "('".$params['name']."','".$params['amount']."','".$params['description']."') ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $ci->db->insert_id();
    }
    function update($params){
        $sql = "update departments set name= '".$params["name"]."',description='".$params["description"]."' ";
        $sql.= "where ";
        $sql.= "id='".$params['id']."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $sql;
    }    
}