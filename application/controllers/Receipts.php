<?php
class Receipts extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
    function create(){
        $this->load->model("Receipt");
        echo $this->Receipt->create();
    }
    function getmax(){
        $this->load->model("Receipt");
        echo $this->Receipt->getmax(date("m"));
                //echo "EL/".date("y")."/".date("m")."/".$this->getmax(date("m"));

    }
    function save(){
        $this->load->model("Receipt");
        echo $this->Receipt->save();
    }
}