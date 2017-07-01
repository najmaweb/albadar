<?php
class Reports extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("report");
        $this->load->helper("datetime");
        $this->load->model("setting");
    }
    function index(){
        session_start();
        checklogin();
        $data = array(
            "breadcrumb" => array(1=>"Laporan",2=>"Daftar"),
            "formtitle"=>"Laporan-laporan",
            "feedData"=>"reports",
            "err_message"=>"",
            "role"=>$this->User->getrole()
        );
        $this->load->view("reports/index",$data);
    }
    function dailytransactions(){
        session_start();
        checklogin();
        $data = array(
            "breadcrumb" => array(1=>"Laporan",2=>"Rekap Transaksi Harian"),
            "formtitle"=>"Rekap Transaksi Harian",
            "feedData"=>"reports",
            "err_message"=>"",
            "role"=>$this->User->getrole()
        );
        $this->load->view("reports/dailytransactions",$data);
    }
    function sppbimbel(){
        session_start();
        checklogin();
        $pyear = $this->setting->getcurrentyear();
        $spp = $this->report->getspp($pyear);
        $bimbel = $this->report->getbimbel($pyear);
        $data = array(
            "breadcrumb" => array(1=>"Laporan",2=>"Rekap Pembayaran SPP &amp; Bimbel"),
            "formtitle"=>"Rekap Pembayaran SPP &amp; Bimbel",
            "feedData"=>"reports",
            "err_message"=>"",
            "role"=>$this->User->getrole(),
            "pyear"=>$pyear,
            "spp"=>$spp,
            "bimbel"=>$bimbel,
            "spptotal"=>$this->report->getspptotal($pyear)[0]->spp,
            "bimbeltotal"=>$this->report->getbimbeltotal($pyear)[0]->bimbel
        );
        $this->load->view("reports/sppbimbel",$data);
    }
    function dubuku(){
        session_start();
        checklogin();
        $data = array(
            "breadcrumb" => array(1=>"Laporan",2=>"Rekap Pembayaran DU &amp; Buku"),
            "formtitle"=>"Rekap Pembayaran DU &amp; Buku",
            "feedData"=>"reports",
            "err_message"=>"",
            "role"=>$this->User->getrole()
        );
        $this->load->view("reports/dubuku",$data);
    }
    function tertanggung(){
        session_start();
        checklogin();
        $data = array(
            "breadcrumb" => array(1=>"Laporan",2=>"Rekap Tertanggung"),
            "formtitle"=>"Rekap Tertanggung",
            "feedData"=>"reports",
            "err_message"=>"",
            "role"=>$this->User->getrole()
        );
        $this->load->view("reports/tertanggung",$data);
    }
    function rekapsppperkelas(){
        session_start();
        checklogin();
        $pyear = $this->setting->getcurrentyear();
        $spp = $this->report->getspp($pyear);
        $bimbel = $this->report->getbimbel($pyear);
        $data = array(
            "breadcrumb" => array(1=>"Laporan",2=>"Rekap Pembayaran SPP"),
            "formtitle"=>"Rekap Pembayaran SPP",
            "feedData"=>"reports",
            "err_message"=>"",
            "role"=>$this->User->getrole(),
            "pyear"=>$pyear,
            "spp"=>$spp,
            "bimbel"=>$bimbel,
            "spptotal"=>$this->report->getspptotal($pyear)[0]->spp,
            "bimbeltotal"=>$this->report->getbimbeltotal($pyear)[0]->bimbel,"periodmonths"=>getperiodmonths(),
            "objs"=>$this->report->getrekapsppperkelas()
        );
        $this->load->view("reports/rekapsppperkelas",$data);
    }
    function rekapbimbelperkelas(){
        session_start();
        checklogin();
        $pyear = $this->setting->getcurrentyear();
        $data = array(
            "breadcrumb" => array(1=>"Laporan",2=>"Rekap Pembayaran Bimbel"),
            "formtitle"=>"Rekap Pembayaran Bimbel",
            "feedData"=>"reports",
            "err_message"=>"",
            "role"=>$this->User->getrole(),
            "pyear"=>$pyear,
            "periodmonths"=>getperiodmonths(),
            "objs"=>$this->report->getrekapbimbelperkelas()
        );
        $this->load->view("reports/rekapbimbelperkelas",$data);
    }
    function getsumrekapbimbelperkelas(){
        echo $this->report->getsumrekapbimbelperkelas();
    }
}