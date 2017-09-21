<?php
class Employee extends CI_Model{
    var $nrp;
    var $id;
    var $tname;
    function __construct($id = null){
        parent::__construct();
        $this->id = $id;
        $this->tname = "employees";
        $this->load->helper("datetime");
    }
    function get(){
        $sql = "select a.id,a.nname,fname,mname,lname,birthday, gender, ";
        $sql.= "a.department_id,b.name department,a.role,a.company_id,c.name company, ";
        $sql.= "a.startdate ";
        $sql.= "from employees a ";
        $sql.= "left outer join departments b on b.id=a.department_id ";
        $sql.= "left outer join companies c on c.id=a.company_id ";
        $sql.= "where a.id=".$this->id;
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result()[0];
    }
    function gets(){
        $sql = "select a.id,a.nname,birthday,b.name department,a.startdate,a.role,a.gender ";
        $sql.= "from employees a ";
        $sql.= "right outer join departments b on b.id=a.department_id ";
        $sql.= "where a.status='1'";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function getrole(){
        return '1';
    }
    function remove($id){
        $sql = "delete from employees where id=".$id;
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $sql;
    }
    function save($params){
        $keys = array();$vals = array();
        foreach($params as $key=>$val){
            array_push($keys,$key);
            if($key=="startdate"){
                $val = convertdateformat($val,"dd/mm/yyyy","yyyy-mm-dd");
            }
            array_push($vals,$val);
        }
        $sql = "insert into employees (".implode(",",$keys).") ";
        $sql.= "values ";
        $sql.= "('".implode("','",$vals)."') ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $ci->db->insert_id();
    }
    function _save($params){
        $sql = "insert into employees (nname,fname,mname,lname,department_id) ";
        $sql.= "values ";
        $sql.= "('".$params['nname']."',";
        $sql.= "'".$params['fname']."',";
        $sql.= "'".$params['mname']."',";
        $sql.= "'".$params['lname']."',";
        $sql.= "'".$params['department_id']."') ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $ci->db->insert_id();
    }
    function update($params){
        $arr = array();
        foreach($params as $key=>$val){
            if($key=="startdate"){
                $val = convertdateformat($val,"dd/mm/yyyy","yyyy-mm-dd");
            }
            array_push($arr,"".$key."='".$val."'");
        }
        $sql = "update employees ";
        $sql.= "set ".implode(",",$arr)." ";
        $sql.= "where ";
        $sql.= "id='".$this->id."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $sql;
    }
}