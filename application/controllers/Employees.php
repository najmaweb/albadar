<?php
class Employees extends CI_Controller{
    var $theme;
    function __construct(){
        parent::__construct();
        $this->load->model("Employee");
        $this->load->helper("Login");
        $this->load->library("Dates");
        $this->theme = $this->config->item("theme");
    }
    function changeemployeepassword(){
        session_start();
        checklogin();
        $employeeid = $this->uri->segment(3);
        $password = $this->uri->segment(4);
        $this->employee->changepassword($employeeid,$password);
    }
    function checkexist($emp_id){
        $sql = "select id from employees where emp_id='".$emp_id."'";
        $que = $this->db->query($sql);
        if($que->num_rows()>0){
            return true;
        }
        return false;
    }
    function login(){
        session_start();
        checklogin();
        $email = $this->uri->segment(3);
        $password = $this->uri->segment(4);
        echo $this->employee->login("risma@gmail.com",$password);
    }
    function index(){
        session_start();
        checklogin();
        $data = array(
            "breadcrumb" => array(1=>"Pegawai",2=>"Daftar Pegawai"),
            "formtitle"=>"Daftar Pegawai",
            "feedData"=>"employee",
            "title"=>"Data Pegawai",
            "objs"=>$this->Employee->getemployees(),
            "parent"=>"employees",
            "role"=>$this->Employee->getrole($_SESSION["userid"])
        );
        $this->load->view("employees/".$this->theme."/employees",$data);
    }
    function add(){
        session_start();
        checklogin();
        $data = array(
            "breadcrumb" => array(1=>"Pegawai",2=>"Penambahan"),
            "formtitle"=>"Penambahan Pegawai",
            "feedData"=>"employee",
            "employees"=>$this->employee->getemployees(),
            "grades"=>$this->Grade->getclassarray(),
            "sppgroups"=>$this->Sppgroup->getsppgrouparray(),
            "role"=>$this->employee->getrole($_SESSION["employeeid"])
        );
        $this->load->view("employees/add",$data);        
    }
    function edit(){
        session_start();
        checklogin();
        $employee = new Employee($this->uri->segment(3));
        $data = array(
            "breadcrumb" => array(1=>"Pegawai",2=>"Edit"),
            "formtitle"=>"Edit Pegawai",
            "feedData"=>"employee",
            "title"=>"Edit Pegawai",
            "obj"=>$employee->getemployee(),
            "parent"=>"employees",
            "role"=>$employee->getrole($_SESSION["employeeid"]),
            "roles"=>'["Programmer","IT Manager","IT Supervisor","IT Staff","Full Stack Developer"]',
            "departments"=>'["IT","Accounting","Purchasing","Marketing"]',
        );
        $this->load->view("employees/".$this->theme."/edit",$data);        
    }
    function getjson(){
        session_start();
        checklogin();
        $year = $this->dates->getcurrentyear();
        $sql = "select a.id,a.name,email from employees a ";
        $que = $this->db->query($sql);
        $res = $que->result();
        $arr = array();
		foreach($res as $obj){
			array_push($arr,'{"id":"'.$obj->id.'","name":"'.$obj->name.'","email":"'.$obj->email.'"}');
		}
		echo '{"out":['.implode(",",$arr).']}';
    }
    function importfinished(){
        $data = array(
            "info1"=>"Anda telah mengimport",
            "info2"=>"File csv pegawai",
            "redirect"=>"../../employees"
        );
        $this->load->view("employees/info",$data);
    }
    function remove(){
        session_start();
        checklogin();
        $id = $this->uri->segment(3);
        $this->employee->remove($id);
        redirect("../../");
    }
    function save(){
        session_start();
        checklogin();
        $params = $this->input->post();
        $this->employee->save($params);
        redirect("../index");
    }
    function savefromcsv(){
        $params = $this->input->post();
        print_r($params);
        $this->load->helper("terbilang");
        if(isset($_POST["btnsavedata"])){
            for($c=0;$c<count($params["name"]);$c++){
                if($this->checkexist(add_trailing_zero($params["emp_id"][$c],6))){
                    $sql = "update employees ";
                    $sql.= "set nname='".str_replace("'","''",$params["name"][$c])."', ";
                    $sql.= " fname='".$params["fname"][$c]."', ";
                    $sql.= " mname='".$params["mname"][$c]."', ";
                    $sql.= " lname='".$params["lname"][$c]."', ";
                    $sql.= " department_id='".$params["department_id"][$c]."' ";
                    $sql.= "where emp_id='".add_trailing_zero($params["emp_id"][$c],6)."'";
                    $this->db->query($sql);
                }else{
                    $sql = "insert into employees ";
                    $sql.= "(startdate,emp_id,nname,fname,mname,lname,department_id,shift_id) ";
                    $sql.= "values ";
                    $sql.= "(";
                    $sql.= "'".str_replace("'","''",$params["startdate"][$c])."',";
                    $sql.= "'".str_replace("'","''",$params["emp_id"][$c])."',";
                    $sql.= "'".str_replace("'","''",$params["name"][$c])."',";
                    $sql.= "'".str_replace("'","''",$params["fname"][$c])."',";
                    $sql.= "'".str_replace("'","''",$params["mname"][$c])."',";
                    $sql.= "'".str_replace("'","''",$params["lname"][$c])."',";
                    $sql.= "'".str_replace("'","''",$params["department_id"][$c])."',";
                    $sql.= "'".str_replace("'","''",$params["shift_id"][$c])."'";
                    $sql.= ")";
                    $this->db->query($sql);
                }
            }
        }
        redirect("../../employees/importfinished");
    }
    function update(){
        session_start();
        checklogin();
        $params = $this->input->post();
        $employee = new Employee($params["id"]);
        echo $employee->update($params);
        redirect("../index");
    }
    function import(){
        session_start();
        checklogin();
        $data = array(
            "breadcrumb" => array(1=>"Siswa",2=>"Import CSV"),
            "formtitle"=>"Import Pegawai",
            "feedData"=>"siswa",
            "objs"=>$this->Employee->getEmployees(),
            "role"=>$this->Employee->getrole($_SESSION["userid"])
        );
        $this->load->view("employees/".$this->theme."/import",$data);
    }
    function importcsv(){
        session_start();
        $params = $this->input->post();
        if(isset($_POST["submit"]))
        {
            $file = $_FILES['file']['tmp_name'];
            $handle = fopen($file, "r");
            $c = 0;
            $objarr = array();
            while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
            {
                $startdate = $filesop[0];
    			$emp_id = $filesop[1];
                $name = $filesop[2];
    			$fname = $filesop[3];
    			$mname = $filesop[4];
    			$lname = $filesop[5];
    			$department_id = $filesop[6];
    			$shift_id = $filesop[7];
                array_push($objarr,array(
                    "startdate"=>$startdate,"emp_id"=>$emp_id,
                    "name"=>$name,"fname"=>$fname,
                    "mname"=>$mname,"lname"=>$lname,
                    "department_id"=>$department_id,"shift_id"=>$shift_id,
                )
                );
                $c = $c + 1;
            }
            $filesop = fgetcsv($handle, 1000, ",");
            $data = array(
                "results" =>$objarr,
                "role"=>"1",
                "feedData"=>"employees"
            );
            $this->load->view("employees/importresult",$data);
        }        
    }
}