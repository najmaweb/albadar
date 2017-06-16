<?php
class Cashier extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper("inflector");
    }
    function index(){
        $this->load->library("Dates");
        $this->load->helper("form");
        $data = array(
            "breadcrumb" => array(1=>"Pembayaran",2=>"SPP"),
            "formtitle"=>"Pembayaran SPP",
            "feedData"=>"cashier",
            "months"=>$this->dates->getmonthsarray(),
            "years"=>$this->dates->getyearsarray(),
            "curmonth"=>date('Y'),
            "err_message"=>""
        );
        $this->load->view("cashiers/spp",$data);
    }
    function previewkwitansi(){
        $params = $this->input->post();
        /*
        foreach($params as $key=>$val){
            echo $key . ' : ' . $val;
        }
        */
        $check = true;
        if((!isset($params["name"])||trim($params["name"]===""))){
            $check = false;
            $err_msg = "Siswa belum dipilih";
        }
        if((trim($params["paid"]===""))||($params["paid"]==="0")){
            $check = false;
            $err_msg = "Jumlah Pembayaran tidak boleh kosong";
        }
        if((!$check)){
            $this->load->library("Dates");
            $this->load->helper("form");
            $data = array(
                "breadcrumb" => array(1=>"Pembayaran",2=>"SPP"),
                "formtitle"=>"Pembayaran SPP",
                "feedData"=>"cashier",
                "months"=>$this->dates->getmonthsarray(),
                "years"=>$this->dates->getyearsarray(),
                "curmonth"=>date('Y'),
                "err_message"=>" (".$err_msg.")"
            );
            $this->load->view("cashiers/spp",$data);
        }else{
            $params["topaid"] = $params["psb"]+$params["book"]+$params["bimbel"]+$params["spp"];
            $this->load->view("cashiers/previewkwitansi",$params);
        }
    }
    function savespp($params){
        
        $purpose = "Untuk pembayaran SPP bulan " . $params["sppfrstmonth"] . '/' . $params["sppfrstyear"];
        $purpose.= " - " . $params["sppnextmonth"] . '/' . $params["sppnextyear"];
        $sql = "insert into spp ";
        $sql.= "(nis,amount,yearmonth,paymenttype,purpose) ";
        $sql.= "values ";
        $sql.= "('".$params["nis"]."','".$params["spp"]."','".$params["frstyear"].$params["frstmonth"]."','1','".$purpose."')";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        $this->savedupsb($params);
        $this->savepembayaranbuku($params);
        $this->kwitansi($params);
    }
    function savedupsb($params){
        $this->load->library("Dates");
        $currentyear = $this->dates->getcurrentyear();
        $sql = "insert into dupsb ";
        $sql.= "(nis,amount,year,paymenttype) ";
        $sql.= "values ";
        $sql.= "('".$params["nis"]."','".$params["psb"]."','".$currentyear."','1')";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
    }
    function savepembayaranbuku($params){
        $this->load->library("Dates");
        $currentyear = $this->dates->getcurrentyear();
        $sql = "insert into pembayaranbuku ";
        $sql.= "(nis,amount,year,paymenttype) ";
        $sql.= "values ";
        $sql.= "('".$params["nis"]."','".$params["book"]."','".$currentyear."','1')";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
    }
    function kwitansi($params){
        $this->load->view("cashiers/kwitansi",$params);
    }
}