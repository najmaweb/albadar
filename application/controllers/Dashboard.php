<?php
class Dashboard extends CI_Controller{
    var $theme;
    function __construct(){
        parent::__construct();
        $this->load->helper("routines");
        $this->load->model("Mdashboard");
        $this->theme = "bm";
    }
    function index(){
        session_start();
        checklogin();
        $data = array(
            "feedData"=>"dashboard",
            "role"=>1,
            "spppercentage"=>$this->Mdashboard->getgenderpercentage(),
            "bimbelpercentage"=>$this->Mdashboard->getgenderpercentage(),
            "dupsbpercentage"=>$this->Mdashboard->getgenderpercentage(),
            "bookpercentage"=>$this->Mdashboard->getgenderpercentage(),
        );
        $this->load->view("dashboard/".$this->theme."/dashboard",$data);
    }
}