<?php
class Employee extends CI_Model{
    var $nrp;
    var $id;
    function __construct($id = null){
        parent::__construct();
        $this->id = $id;
    }
    function getemployee(){
        $sql = "select a.id,a.nname,fname,mname,lname,birthday, ";
        $sql.= "b.name department,a.role,c.name company ";
        $sql.= "from employees a ";
        $sql.= "left outer join departments b on b.id=a.department_id ";
        $sql.= "left outer join companies c on c.id=a.company_id ";
        $sql.= "where a.id=".$this->id;
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result()[0];
    }
    function getemployees(){
        $sql = "select a.id,a.nname,birthday,b.name department,a.startdate,a.role ";
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
        $sql = "update employees set nname= '".str_replace("'","''",$params["nname"])."',fname='".$params["description"]."', ";
        $sql.= "sppgroup_id=".$params["sppgroup_id"].",dupsbgroup_id=".$params["dupsbgroup_id"].",";
        $sql.= "grade_id=".$params["grade_id"].",bimbelgroup_id=".$params["bimbelgroup_id"].",nis='".$params["nis"]."',initmonth=".$params["initmonth"].",inityear=".$params["inityear"]." ";
        $sql.= "where ";
        $sql.= "id='".$params['id']."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);

        $sql = "update employeeshistory set name= '".str_replace("'","''",$params["name"])."',description='".$params["description"]."', ";
        $sql.= "sppgroup_id=".$params["sppgroup_id"].",dupsbgroup_id=".$params["dupsbgroup_id"].",bookpaymentgroup_id=".$params["bookpaymentgroup_id"].",";
        $sql.= "grade_id=".$params["grade_id"].",bimbelgroup_id=".$params["bimbelgroup_id"].",nis='".$params["nis"]."' ";
        $sql.= "where ";
        $sql.= "id='".$params['id']."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);

        return $sql;
    }
}