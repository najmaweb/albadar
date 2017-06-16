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
}