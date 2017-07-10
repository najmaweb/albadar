<?php
class Cashier extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("Mcashier");
        $this->load->helper("terbilang");
        $this->load->library("Dates");
        $this->load->helper("datetime");
    }
    function index(){
        session_start();
        checklogin();
        $this->load->helper("form");
        $data = array(
            "breadcrumb" => array(1=>"Pembayaran",2=>"SPP"),
            "formtitle"=>"Pembayaran SPP",
            "feedData"=>"cashier",
            "months"=>$this->dates->getmonthsarray(),
            "years"=>$this->dates->getyearsarray(),
            "curmonth"=>date('m'),
            "curyear"=>date("Y"),
            "err_message"=>"",
            "role"=>$this->User->getrole(),
        );
        $this->load->view("cashiers/spp",$data);
    }
    function checksession(){
        if (session_status() == PHP_SESSION_NONE) {
            if(!isset($_SESSION["username"])){
                redirect("../../main/login");
            }
            echo $_SESSION["username"];
        }
    }
    function savesession(){
        $CHECKSESSION = false;
        if($CHECKSESSION){
            $this->checksession();
        }
        $params = $this->input->post();
        $currentyear = $this->dates->getcurrentyear();
        $DEBUG = false;
        if($DEBUG){
            foreach($params as $key=>$val){
                echo $key . ' : ' . $val;
            }
        }
        $montharray = array();
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
        if($params["bimbelfrstyear"]===$params["bimbelnextyear"]){
            $bimbelmonthcount += $params["bimbelnextmonth"] - $params["bimbelfrstmonth"];
        }
        if($params["bimbelnextyear"]<$params["bimbelfrstyear"]){
            $firstyearmonthcount = 12-$params["bimbelfrstmonth"];
            $yearcount = $params["bimbelnextyear"] - $params["bimbelfrstyear"];
            $lastyearmonthcount = $params["bimbelnextmonth"]; 
            $bimbelmonthcount += $firstyearmonthcount + 12*$yearcount + $lastyearmonthcount;
        }
        session_start();
        $_SESSION["sppfrstmonth"] = $params["sppfrstmonth"];
        $_SESSION["sppfrstyear"] = $params["sppfrstyear"];
        $_SESSION["sppnextmonth"] = $params["sppnextmonth"];
        $_SESSION["sppnextyear"] = $params["sppnextyear"];
        $_SESSION["nis"] = $params["nis"];
        $_SESSION["studentname"] = $params["studentname"];
        $_SESSION["spp"] = removedot($params["spp"]);
        $_SESSION["bimbelfrstyear"] = $params["bimbelfrstyear"];
        $_SESSION["bimbelfrstmonth"] = $params["bimbelfrstmonth"];
        $_SESSION["bimbelnextmonth"] = $params["bimbelnextmonth"];
        $_SESSION["bimbelnextyear"] = $params["bimbelnextyear"];
        $_SESSION["psb"] = removedot($params["psb"]);
        $_SESSION["book"] = removedot($params["book"]);
        $_SESSION["grade"] = $params["grade"];
        $_SESSION["cashpay"] = removedot($params["cashpay"]);
        $_SESSION["bimbel"] = removedot($params["bimbel"]);
        $_SESSION["dupsbpaid"] = $this->Mcashier->getdupsbpaid($params["nis"],$currentyear);
        $_SESSION["totaltagihan"] = $this->Mcashier->gettotaltagihan($params["nis"],$currentyear);
        $_SESSION["total"] = $_SESSION["psb"]+$_SESSION["spp"]+$_SESSION["book"]+$_SESSION["bimbel"];
        $_SESSION["sppmonthcount"] = $sppmonthcount;
        $_SESSION["bimbelmonthcount"] = $bimbelmonthcount;
        $_SESSION["orispp"] = $params["orispp"];
        $_SESSION["oribimbel"] = $params["oribimbel"];
        $_SESSION["dupsbremain"] = $_SESSION["totaltagihan"] - $_SESSION["dupsbpaid"];
        if(isset($params["sppcheckbox"])){
            $_SESSION["sppcheckbox"] = "1";
        }else{
            $_SESSION["sppcheckbox"] = "0";
        }
        $this->previewkwitansi();
    }
    function previewkwitansi(){
        $check = true;
        $DEBUG = false;
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
            "bimbelfrstyear"=>$_SESSION["bimbelfrstyear"],
            "bimbelfrstmonth"=>$_SESSION["bimbelfrstmonth"],
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
            "monthsarray"=>$this->dates->getmonthsarray(),
            "orispp"=>$_SESSION["orispp"],
            "oribimbel"=>$_SESSION["oribimbel"],
            "sppcheckbox"=>$_SESSION["sppcheckbox"],
            "role"=>$this->User->getrole(),
            "periodmonths"=>getperiodmonths(),
        );
        if($DEBUG){
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
        $this->savebimbel($params);
        $this->savespp($params);
    }
    function savebimbel($params){
        session_start();
        $montharray = getmontharray($params["bimbelfrstmonth"],$params["bimbelfrstyear"],$params["bimbelnextmonth"],$params["bimbelnextyear"]);
        foreach($montharray as $monthyear){
            $month = substr($monthyear,0,2);
            $year = substr($monthyear,2,4);
            $purpose = "Untuk pembayaran Bimbel bulan " . $month . '/' . $year;
            $sql = "insert into bimbel ";
            $sql.= "(nis,amount,pyear,pmonth,paymenttype,purpose,createuser) ";
            $sql.= "values ";
            $sql.= "('".$params["nis"]."','".$params["oribimbel"]."','".$year."','".$month."','1','".$purpose."','".$_SESSION["username"]."')";
            $ci = & get_instance();
            $que = $ci->db->query($sql);
        }
    }
    function savespp($params){
        session_start();
        $montharray = getmontharray($params["sppfrstmonth"],$params["sppfrstyear"],$params["sppnextmonth"],$params["sppnextyear"]);
        //if($params["sppcheckbox"]>0){
            foreach($montharray as $monthyear){
                $month = substr($monthyear,0,2);
                $year = substr($monthyear,2,4);
                $purpose = "Untuk pembayaran SPP bulan " . $month . '/' . $year;
                $sql = "insert into spp ";
                $sql.= "(nis,amount,pyear,pmonth,paymenttype,purpose,createuser) ";
                $sql.= "values ";
                $sql.= "('".$params["nis"]."','".$params["orispp"]."','".$year."','".$month."','1','".$purpose."','".$_SESSION["username"]."')";
                $ci = & get_instance();
                $que = $ci->db->query($sql);
            }
        //}
        echo $montharray[0];
        $this->savedupsb($params);
        $this->savepembayaranbuku($params);
        $this->kwitansi($params);
    }
    function savedupsb($params){
        if($params["psb"]>0){
            $this->load->library("Dates");
            $currentyear = $this->dates->getcurrentyear();
            $sql = "insert into dupsb ";
            $sql.= "(nis,amount,year,paymenttype,createuser) ";
            $sql.= "values ";
            $sql.= "('".$params["nis"]."','".$params["psb"]."','".$currentyear."','1','".$_SESSION["username"]."')";
            $ci = & get_instance();
            $que = $ci->db->query($sql);
        }
    }
    function savepembayaranbuku($params){
        if($params["book"]>0){
            $this->load->library("Dates");
            $currentyear = $this->dates->getcurrentyear();
            $sql = "insert into pembayaranbuku ";
            $sql.= "(nis,amount,year,paymenttype,createuser) ";
            $sql.= "values ";
            $sql.= "('".$params["nis"]."','".$params["book"]."','".$currentyear."','1','".$_SESSION["username"]."')";
            $ci = & get_instance();
            $que = $ci->db->query($sql);
        }
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
            "bimbelfrstyear"=>$_SESSION["bimbelfrstyear"],
            "bimbelfrstmonth"=>$_SESSION["bimbelfrstmonth"],
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
            "total"=>$_SESSION["total"],
            "sppmonthcount"=>$_SESSION["sppmonthcount"],
            "bimbelmonthcount"=>$_SESSION["bimbelmonthcount"],
            "monthsarray"=>$this->dates->getmonthsarray(),
            "role"=>$this->User->getrole(),
            "periodmonths"=>getperiodmonths(),
        );
        $params["topaid"] = $_SESSION["total"];
        $this->load->view("cashiers/kwitansi",$params);
    }
}