<?php
class Students extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("Student");
        $this->load->model("Grade");
        $this->load->model("User");
        $this->load->model("Sppgroup");
        $this->load->model("Dupsbgroup");
        $this->load->library("Dates");
        $this->load->helper("datetime");
    }
    function index(){
        $data = array(
            "breadcrumb" => array(1=>"Siswa",2=>"Daftar"),
            "formtitle"=>"Daftar Siswa",
            "feedData"=>"siswa",
            "objs"=>$this->Student->getStudents(),
            "role"=>$this->User->getrole()
        );
        $this->load->view("students/students",$data);
    }
    function add(){
        $data = array(
            "breadcrumb" => array(1=>"Siswa",2=>"Penambahan"),
            "formtitle"=>"Penambahan Siswa",
            "feedData"=>"siswa",
            "students"=>$this->Student->getStudents(),
            "grades"=>$this->Grade->getclassarray(),
            "sppgroups"=>$this->Sppgroup->getsppgrouparray(),
            "role"=>$this->User->getrole()
        );
        $this->load->view("students/add",$data);        
    }
    function edit(){
        $data = array(
            "breadcrumb" => array(1=>"Siswa",2=>"Edit"),
            "formtitle"=>"Edit siswa",
            "feedData"=>"siswa",
            "obj"=>$this->Student->getStudent($this->uri->segment(3)),
            "grades"=>$this->Grade->getclassarray(),
            "sppgroups"=>$this->Sppgroup->getsppgrouparray(),
            "dupsbgroups"=>$this->Dupsbgroup->getDupsbgrouparray(),
            "role"=>$this->User->getrole()
        );
        $this->load->view("students/edit",$data);        
    }
    function getjson(){
        $year = $this->dates->getcurrentyear();
        $sql = "select a.id,a.name,a.nis,b.name grade,c.amount spp from students a ";
        $sql.= "left outer join grades b on b.id=a.grade_id ";
        $sql.= "left outer join sppgroups c on c.id=a.sppgroup_id ";
        $que = $this->db->query($sql);
        $res = $que->result();
        $arr = array();
		foreach($res as $obj){
			array_push($arr,'{"value":"'.$obj->nis.' '.$obj->name.'('.$obj->grade.')","data":"'.$obj->id.'","nis":"'.$obj->nis.'","spp":"'.$obj->spp.'","name":"'.$obj->name.'","grade":"'.$obj->grade.'"}');
		}
		echo '{"out":['.implode(",",$arr).']}';
    }
    function getsppstatus(){
        $des = "MENGEMBALIKAN STATUS BELUM PERNAH MEMBAYAR JIKA JUMLAH 0";
        $des.= "MENGEMBALIKAN STATUS TAHUNBULAN TERAKHIR JIKA JUMLAH > 0";
        $nis = $this->uri->segment(3);
        $sql = "select * from spp ";
        $sql.= "where nis='".$nis."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        $res = $que->result();
        if($que->num_rows()===0){
            echo "BELUM_BAYAR";
        }else{
            $sql = "select max(yearmonth) lastpay from students ";
            $sql.= "where nis='".$nis."'";
            $qym = $ci->db->query($sql);
            $rym = $qym->result();
            echo $ym->lastpay;
        }
    }
    function getproperties(){
        $nis = $this->uri->segment(3);
        $year = $this->dates->getcurrentyear();
        $sql = "select a.id,a.name,b.amount spp,c.amount bimbel,d.amount dupsb, ";
        $sql.= "count(e.amount) dupsbpaid, ";
        $sql.= "(d.amount-sum(e.amount)) dupsbremain, ";
        $sql.= "max(f.pyear)maxyear,max(f.pmonth)maxmonth ";
        $sql.= "from students a ";
        $sql.= "left outer join sppgroups b on b.id=a.sppgroup_id ";
        $sql.= "left outer join bimbelgroups c on c.id=a.bimbelgroup_id ";
        $sql.= "left outer join dupsbgroups d on d.id=a.dupsbgroup_id ";
        $sql.= "left outer join dupsb e on e.nis=a.nis ";
        $sql.= "left outer join spp f on f.nis=a.nis ";
        $sql.= "where a.nis = '".$nis."' ";
        $sql.= "and a.year='" . $year . "' ";
        $sql.= "group by a.id,a.name,b.amount,c.amount,d.amount";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        $res = $que->result()[0];
        if($res->maxmonth==12){
            $maxmonth = 1;
            $maxyear = $res->maxyear + 1;
        }else{
            $maxmonth = addzero($res->maxmonth+1);
            $maxyear = addzero($res->maxyear);
        }
        echo '{"spp":"'.$res->spp.'","bimbel":"'.$res->bimbel.'","dupsbremain":"'.$res->dupsbremain.'","maxyear":"'.$maxyear.'","maxmonth":"'.$maxmonth.'"}';
    }
    function remove(){
        $id = $this->uri->segment(3);
        $this->Student->remove($id);
        redirect("../../");
    }
    function save(){
        $params = $this->input->post();
        $this->Student->save($params);
        redirect("../index");
    }
    function update(){
        $params = $this->input->post();
        echo $this->Student->update($params);
        redirect("../index");
    }    
}