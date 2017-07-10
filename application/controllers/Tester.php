<?php
class Tester extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
    function getterbilang(){
        $str = $this->uri->segment(3);
        $this->load->helper("currency");
        terbilang($str);
    }
    function get_terbilang(){
        $this->load->helper("terbilang");
        $str = $this->uri->segment(3);
        echo terbilang($str);
    }
    function getmonths(){
        $this->load->helper("datetime");
        echo "TEST Get Months <br />";
        $arr = getmontharray(1,2016,3,2017);
        foreach($arr as $key=>$val){
            echo $key . " and " . $val . "<br />";
        }
    }
    function addzero(){
        $str = $this->uri->segment(3);
        $this->load->helper("datetime");
        echo "TEST Add Zero <br />";
        echo addzero($str);
    }
    function phpinfo(){
        phpinfo();
    }
    function removezero(){
        $this->load->helper("datetime");
        $number = $this->uri->segment(3);
        echo removezero($number);
    }
    function getmax(){
        $nis = $this->uri->segment(3);
        $this->load->model("Mcashier");
        $remain = $this->Mcashier->getsppmaxyearmonth($nis);
        echo $remain["maxyear"] . "<br />";
        echo $remain["maxmonth"] . "<br />";
    }
    function getsppremain(){
        $this->load->model("Mcashier");
        $nis = $this->uri->segment(3);
        echo $this->Mcashier->getsppremain($nis);
    }
    function changepassword(){
        $id= $this->uri->segment(3);
        $pass = $this->uri->segment(4);
        if ($this->User->changepassword($id,$pass)){
            echo "sukses";
        }else{
            echo "tidak sukses";
        };
    }
}