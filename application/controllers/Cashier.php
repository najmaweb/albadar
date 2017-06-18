<?php
class Cashier extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper("inflector");
        $this->load->model("Mcashier");
        $this->load->helper("terbilang");
        $this->load->library("Dates");
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
    function checksession(){
        if(isset($_SESSION["nis"])){
            return true;
        }
        redirect("../");
    }
    function removedot($str){
        return str_replace(",","",$str);
    }
    function savesession(){
        //$this->checksession();
        $params = $this->input->post();
        $DEBUG = false;
        if($DEBUG){
            foreach($params as $key=>$val){
                echo $key . ' : ' . $val;
            }
        }
        $sppmonthcount = 1;
        if($params["sppfrstyear"]===$params["sppnextyear"]){
            $sppmonthcount += $params["sppnextmonth"] - $params["sppfrstmonth"];
        }
        if($params["sppnextyear"]<$params["sppfrstyear"]){
            $firstyearmonthcount = 12-$params["sppfrstmonth"];
            $yearcount = $params["sppnextyear"] - $params["sppfrstyear"];
            $lastyearmonthcount = $params["sppnextmonth"]; 
            $sppmonthcount += $firstyearmonthcount + 12*$yearcount + $lastyearmonthcount;
        }

        $bimbelmonthcount = 1;
        if($params["frstyear"]===$params["nextyear"]){
            $bimbelmonthcount += $params["nextmonth"] - $params["frstmonth"];
        }
        if($params["nextyear"]<$params["frstyear"]){
            $firstyearmonthcount = 12-$params["frstmonth"];
            $yearcount = $params["nextyear"] - $params["frstyear"];
            $lastyearmonthcount = $params["nextmonth"]; 
            $bimbelmonthcount += $firstyearmonthcount + 12*$yearcount + $lastyearmonthcount;
        }
        session_start();
        $_SESSION["sppfrstmonth"] = $params["sppfrstmonth"];
        $_SESSION["sppfrstyear"] = $params["sppfrstyear"];
        $_SESSION["sppnextmonth"] = $params["sppnextmonth"];
        $_SESSION["sppnextyear"] = $params["sppnextyear"];
        $_SESSION["nis"] = $params["nis"];
        $_SESSION["studentname"] = $params["studentname"];
        $_SESSION["spp"] = $this->removedot($params["spp"]);
        $_SESSION["frstyear"] = $params["frstyear"];
        $_SESSION["frstmonth"] = $params["frstmonth"];
        $_SESSION["bimbelnextmonth"] = $params["nextmonth"];
        $_SESSION["bimbelnextyear"] = $params["nextyear"];
        $_SESSION["psb"] = $this->removedot($params["psb"]);
        $_SESSION["book"] = $this->removedot($params["book"]);
        $_SESSION["grade"] = $params["grade"];
        $_SESSION["cashpay"] = $this->removedot($params["cashpay"]);
        $_SESSION["bimbel"] = $this->removedot($params["bimbel"]);
        $_SESSION["dupsbremain"] = $this->Mcashier->getdupsbremain($params["nis"]);
        $_SESSION["dupsbpaid"] = $this->Mcashier->getdupsbpaid($params["nis"]);
        $_SESSION["totaltagihan"] = $this->Mcashier->gettotaltagihan($params["nis"]);
        $_SESSION["total"] = $_SESSION["psb"]+$_SESSION["spp"]+$_SESSION["book"]+$_SESSION["bimbel"];
        $_SESSION["sppmonthcount"] = $sppmonthcount;
        $_SESSION["bimbelmonthcount"] = $bimbelmonthcount;
        $this->previewkwitansi();
    }
    function previewkwitansi(){
        $check = true;
        $debug = false;
        //session_start();
        if((!isset($_SESSION["studentname"])||trim($_SESSION["studentname"]===""))){
            $check = false;
            $err_msg = "Siswa belum dipilih";
        }
        if((trim($_SESSION["cashpay"]===""))||($_SESSION["cashpay"]==="0")){
            $check = false;
            $err_msg = "Jumlah Pembayaran tidak boleh kosong";
        }
        $params = array(
            "sppfrstmonth"=>$_SESSION["sppfrstmonth"],
            "sppfrstyear"=>$_SESSION["sppfrstyear"],
            "sppnextmonth"=>$_SESSION["sppnextmonth"],
            "sppnextyear"=>$_SESSION["sppnextyear"],
            "nis"=>$_SESSION["nis"],
            "studentname"=>$_SESSION["studentname"],
            "spp"=>$_SESSION["spp"],
            "frstyear"=>$_SESSION["frstyear"],
            "frstmonth"=>$_SESSION["frstmonth"],
            "bimbelnextmonth"=>$_SESSION["bimbelnextmonth"],
            "bimbelnextyear"=>$_SESSION["bimbelnextyear"],
            "psb"=>$_SESSION["psb"],
            "book"=>$_SESSION["book"],
            "grade"=>$_SESSION["grade"],
            "cashpay"=>$_SESSION["cashpay"],
            "bimbel"=>$_SESSION["bimbel"],
            "dupsbremain"=>$_SESSION["dupsbremain"],
            "dupsbpaid"=>$_SESSION["dupsbpaid"],
            "totaltagihan"=>$_SESSION["totaltagihan"],
            "total"=>$_SESSION["total"],
            "sppmonthcount"=>$_SESSION["sppmonthcount"],
            "bimbelmonthcount"=>$_SESSION["bimbelmonthcount"],
            "monthsarray"=>$this->dates->getmonthsarray()
        );
        if($debug){
            echo "SPP : ". $_SESSION["spp"] . "<br />";
            echo "psb : ". $_SESSION["psb"] . "<br />";
            echo "book : ". $_SESSION["book"] . "<br />";
            echo "Bimbel : ". $_SESSION["bimbel"] . "<br />";
            echo "total : ". $_SESSION["total"] . "<br />";
            echo "dupsbpaid : ". $_SESSION["dupsbpaid"] . "<br />";
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
                "err_message"=>" (".$err_msg.")",
            );
            $this->load->view("cashiers/spp",$data);
        }else{
            $params["topaid"] = $_SESSION["total"];
            $this->load->view("cashiers/previewkwitansi",$params);
        }
    }
    function saveall(){
        $params = $this->input->post();
        $this->savespp($params);
    }
    function savespp($params){
        $purpose = "Untuk pembayaran SPP bulan " . $params["sppfrstmonth"] . '/' . $params["sppfrstyear"];
        $purpose.= " - " . $params["sppnextmonth"] . '/' . $params["sppnextyear"];
        $sql = "insert into spp ";
        $sql.= "(nis,amount,pyear,pmonth,paymenttype,purpose) ";
        $sql.= "values ";
        $sql.= "('".$params["nis"]."','".$params["spp"]."','".$params["sppfrstyear"]."','".$params["sppfrstmonth"]."','1','".$purpose."')";
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
    function kwitansi(){
        session_start();
        $params = array(
            "sppfrstmonth"=>$_SESSION["sppfrstmonth"],
            "sppfrstyear"=>$_SESSION["sppfrstyear"],
            "sppnextmonth"=>$_SESSION["sppnextmonth"],
            "sppnextyear"=>$_SESSION["sppnextyear"],
            "nis"=>$_SESSION["nis"],
            "studentname"=>$_SESSION["studentname"],
            "spp"=>$_SESSION["spp"],
            "frstyear"=>$_SESSION["frstyear"],
            "frstmonth"=>$_SESSION["frstmonth"],
            "bimbelnextmonth"=>$_SESSION["bimbelnextmonth"],
            "bimbelnextyear"=>$_SESSION["bimbelnextyear"],
            "psb"=>$_SESSION["psb"],
            "book"=>$_SESSION["book"],
            "grade"=>$_SESSION["grade"],
            "cashpay"=>$_SESSION["cashpay"],
            "dupsbremain"=>$_SESSION["dupsbremain"],
            "dupsbpaid"=>$_SESSION["dupsbpaid"],
            "totaltagihan"=>$_SESSION["totaltagihan"],
            "bimbel"=>$_SESSION["bimbel"],
            "dupsbremain"=>$_SESSION["dupsbremain"],
            "dupsbpaid"=>$_SESSION["dupsbpaid"],
            "totaltagihan"=>$_SESSION["totaltagihan"],
            "total"=>$_SESSION["total"],
            "sppmonthcount"=>$_SESSION["sppmonthcount"],
            "bimbelmonthcount"=>$_SESSION["bimbelmonthcount"],
            "monthsarray"=>$this->dates->getmonthsarray()
        );
        $params["topaid"] = $_SESSION["total"];
        $this->load->view("cashiers/kwitansi",$params);
    }
}