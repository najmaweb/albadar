<?php
class Main extends CI_Controller{
    var $theme;
    function __construct(){
        parent::__construct();
        $this->load->model("User");
        $this->theme=$this->config->item("theme");
    }
    function changepassword(){
        $this->load->view("changepassword");
    }
    function changepasswordhandler(){
        session_start();
        $params = $this->input->post();
        if(isset($params["save"])){
            if($params["password1"]===$params["password2"]){
                $userid = $_SESSION["userid"];
                $this->User->changepassword($userid,$params["password1"]);
                $data = array(
                    "info1"=>"Passwod anda telah berubah",
                    "info2"=>"Jangan sampai lupa",
                    "redirect"=>"../../cashier"
                );
                $this->load->view("info",$data);
            }else{
                echo "Kedua Password yang anda isikan tidak sama";
            }
        }
        if(isset($params["cancel"])){
            redirect("../../cashier");
        }
    }
    function index(){
        session_start();
        $data = array(
            "breadcrumb" => array(1=>"Siswa",2=>"Entri Nilai"),
            "feedData"=>"evaluasi"
        );
        redirect("../employees");
    }
    function info(){
        session_start();
        $data = array(
            "info1"=>"test",
            "info2"=>"Hi",
            "redirect"=>"../../employees"
        );
        $this->load->view("info",$data);
    }
    function infohandler(){
        $params = $this->input->post();
        redirect($params["redirector"]);
    }
    function login(){
        $data = array(
            "title" => $this->config->item("appname")
        );
        $this->load->view("commons/".$this->theme."/login",$data);
    }
    function loginhandler(){
        $params = $this->input->post();
        $login = $this->User->login($params["email"],$params["password"]);
        switch($login["message"]){
            case "password benar":
                session_start();
                $_SESSION["username"] = $login["username"];
                $_SESSION["userid"] = $login["userid"];
                $_SESSION["employeeid"]=1;
                redirect("../../employees");
            break;
            case "password tidak cocok":
                $data = array(
                    "info1"=>"Password tidak cocok",
                    "info2"=>"",
                    "redirect"=>"../../main/login"
                );
                $this->load->view("info",$data);
            break;
            case "email tidak dikenali":
                $data = array(
                    "info1"=>"Email tidak dikenali",
                    "info2"=>"",
                    "redirect"=>"../../main/login"
                );
                $this->load->view("info",$data);
            break;
        }
        session_write_close();
    }
    function logout(){
        session_start();
        unset($_SESSION["username"]);
        redirect("../../main/login");
    }
    function phpinfo(){
        phpinfo();
    }
}