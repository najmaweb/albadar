<?php
class Dashboard extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper("routines");
    }
    function index(){
        session_start();
        checklogin();
        $data = array("feedData"=>"dashboard","role"=>1);
        $this->load->view("dashboard/dashboard",$data);
    }
}