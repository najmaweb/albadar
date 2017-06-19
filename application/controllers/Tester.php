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
}