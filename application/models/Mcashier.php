<?php
class Mcashier extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function getdupsbremain($nis){
        $sql = "select nis,sum(amount)amnt from dupsb group by nis;";
        return "2598000";
    }
    function getdupsbpaid($nis,$year){
        $sql = "select sum(amount)amnt from dupsb a where nis='".$nis."' and year='".$year."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        if($que->num_rows()===0){
            return 0;
        }
        return $que->result()[0]->amnt;
    }
    function gettotaltagihan($nis,$year){
        $sql = "select sum(b.amount)amnt from students a left outer join dupsbgroups b on b.id=a.dupsbgroup_id where nis='".$nis."' and a.year='".$year."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        if($que->num_rows()===0){
            return 0;
        }
        return $que->result()[0]->amnt;
    }
}