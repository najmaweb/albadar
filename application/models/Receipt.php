<?php
class Receipt extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function getmax($month){
        $ci = & get_instance();
        $sql = "select lpad(max(rorder)+1,4,'0') maxnum from receipts where month(createdate)='".$month."'";
        $que = $ci->db->query($sql);
        $res = $que->result();
        if(is_null($res[0]->maxnum)){
            return '0001';
        }
        return $res[0]->maxnum;
    }
    function create(){
        return "EL/".date("y")."/".date("m")."/".$this->getmax(date("m"));
    }
    function save(){
        $ci = & get_instance();
        $sql = "insert into receipts (receiptno,rorder,createuser) ";
        $sql.= "values ";
        $sql.= "('".$this->create()."','".$this->getmax(date("m"))."','puji') ";
        $que = $ci->db->query($sql);
        echo $sql;
    }
}