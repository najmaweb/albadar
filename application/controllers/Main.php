<?php
class Main extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("User");
    }
    function changepassword(){
        $this->load->view("changepassword");
    }
    function changepasswordhandler(){
        $params = $this->input->post();
        if(isset($params["save"])){
            if($params["password1"]===$params["password2"]){
                //$userid = $_SESSION["userid"];
                $this->User->changepassword(1,$params["password1"]);
            }else{
                echo "Kedua Password yang anda isikan tidak sama";
            }
        }
        if(isset($params["cancel"])){
            redirect("../../cashier");
        }
    }
    function index(){
        $data = array(
            "breadcrumb" => array(1=>"Siswa",2=>"Entri Nilai"),
            "feedData"=>"evaluasi"
        );
        redirect("../cashier");
    }
    function info(){
        $data = array(
            "info1"=>"test",
            "info2"=>"Hi",
            "redirect"=>"../../cashier"
        );
        $this->load->view("info",$data);
    }
    function infohandler(){
        $params = $this->input->post();
        redirect($params["redirector"]);
    }
    function login(){
        $this->load->view("login");
    }
    function loginhandler(){
        $params = $this->input->post();
        switch($this->User->login($params["$email"],$params["password"])){
            case "password benar":
                redirect("/cashier");
            break;
            case "password tidak cocok":
                $data = array(
                    "info1"=>"Password tidak cocok",
                    "info2"=>"",
                    "redirect"=>"../../cashier"
                );
                $this->load->view("info",$data);
            break;
            case "email tidak dikenali":
                $data = array(
                    "info1"=>"Email tidak dikenali",
                    "info2"=>"",
                    "redirect"=>"../../cashier"
                );
                $this->load->view("info",$data);
            break;
        }
    }
}