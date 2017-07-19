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
        session_start();
        checklogin();
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
        session_start();
        checklogin();
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
        session_start();
        checklogin();
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
        session_start();
        checklogin();
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
        session_start();
        checklogin();
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
        session_start();
        checklogin();
        $nis = $this->uri->segment(3);
        $year = $this->dates->getcurrentyear();
        $sql = "select a.id,a.name,b.amount spp,c.amount bimbel,d.amount dupsb, ";
        $sql.= "e.dupsbpaid,j.bookpaymentpaid, ";
        $sql.= "case when e.amount is null then d.amount else (d.amount-e.amount) end  dupsbremain, ";
        $sql.= "case when j.amount is null then i.amount else (i.amount-j.amount) end  bookremain, ";
        $sql.= "case when f.pyear is null then a.inityear else f.pyear end sppmaxyear,case when f.pmonth is null then a.initmonth else f.pmonth end sppmaxmonth, ";
        $sql.= "case when g.pyear is null then a.inityear else g.pyear end bimbelmaxyear,case when g.pmonth is null then a.initmonth else g.pmonth end bimbelmaxmonth ";
        $sql.= "from students a ";
        $sql.= "left outer join sppgroups b on b.id=a.sppgroup_id ";
        $sql.= "left outer join bimbelgroups c on c.id=a.bimbelgroup_id ";
        $sql.= "left outer join dupsbgroups d on d.id=a.dupsbgroup_id ";
        $sql.= "left outer join (select nis,count(amount) dupsbpaid,sum(amount) amount from dupsb where nis='".$nis."' group by nis) e on e.nis=a.nis ";
        $sql.= "left outer join (select a.nis,b.pyear,mmonth pmonth from  (select nis,max(pyear)myear from spp where nis='".$nis."') a left outer join (select nis,pyear,max(pmonth)mmonth from spp where nis='".$nis."' group by nis,pyear) b on b.nis=a.nis and b.pyear=a.myear) f on f.nis=a.nis ";
        $sql.= "left outer join (select a.nis,b.pyear,mmonth pmonth from  (select nis,max(pyear)myear from bimbel where nis='".$nis."') a left outer join (select nis,pyear,max(pmonth)mmonth from bimbel where nis='".$nis."' group by nis,pyear) b on b.nis=a.nis and b.pyear=a.myear) g on g.nis=a.nis ";
        $sql.= "left outer join studentshistory h on h.nis=a.nis ";
        $sql.= "left outer join bookpaymentgroups i on i.id=h.bookpaymentgroup_id ";
        $sql.= "left outer join (select nis,count(amount) bookpaymentpaid,sum(amount) amount from bookpayment where nis='".$nis."' group by nis) j on j.nis=a.nis ";


        $sql.= "where a.nis = '".$nis."' ";
        $sql.= "and a.year='" . $year . "' ";
        $sql.= "group by a.id,a.name,b.amount,c.amount,d.amount,f.pyear,f.pmonth,g.pyear,g.pmonth,dupsbpaid,j.bookpaymentpaid,i.amount,j.amount ";
        $maxquery = "select a.nis,b.pyear,mmonth from  (select nis,max(pyear)myear from bimbel group by nis) a left outer join (select nis,pyear,max(pmonth)mmonth from bimbel group by nis,pyear) b on b.nis=a.nis and b.pyear=a.myear ";
        $maxquery = "select a.nis,b.pyear,mmonth from  (select nis,max(pyear)myear from bimbel where nis='060477') a left outer join (select nis,pyear,max(pmonth)mmonth from bimbel where nis='060477' group by nis,pyear) b on b.nis=a.nis and b.pyear=a.myear ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        if($que->num_rows()===0){
            $spp = $this->Student->getspp($nis);
            $bimbel = $this->Student->getbimbel($nis);
            $dupsb = $this->Student->getdupsb($nis);
            $book = $this->Student->getbook($nis);
            $out = '{"spp":"'.$spp.'",';
            $out.= '"bimbel":"'.$bimbel.'",';
            $out.= '"dupsbremain":"'.$dupsb.'",';
            $out.= '"bookremain":"'.$book.'",';
            $out.= '"sppmaxyear":"'.$this->Setting->getcurrentyear().'",';
            $out.= '"sppmaxmonth":"07",';
            $out.= '"bimbelmaxyear":"'.$this->Setting->getcurrentyear().'",';
            $out.= '"bimbelmaxmonth":"07"}';
            echo $out;
        }else{
            $res = $que->result()[0];
            if($res->sppmaxmonth==12){
                $sppmaxmonth = 1;
                $sppmaxyear = $res->sppmaxyear + 1;
            }else{
                $sppmaxmonth = addzero($res->sppmaxmonth+1);
                $sppmaxyear = addzero($res->sppmaxyear);
            }
            if($res->bimbelmaxmonth==12){
                $bimbelmaxmonth = 1;
                $bimbelmaxyear = $res->bimbelmaxyear + 1;
            }else{
                $bimbelmaxmonth = addzero($res->bimbelmaxmonth+1);
                $bimbelmaxyear = addzero($res->bimbelmaxyear);
            }
            $out = '{"spp":"'.$res->spp.'",';
            $out.= '"bimbel":"'.$res->bimbel.'",';
            $out.= '"dupsbremain":"'.$res->dupsbremain.'",';
            $out.= '"bookremain":"'.$res->bookremain.'",';
            $out.= '"sppmaxyear":"'.$sppmaxyear.'",';
            $out.= '"sppmaxmonth":"'.$sppmaxmonth.'",';
            $out.= '"bimbelmaxyear":"'.$bimbelmaxyear.'",';
            $out.= '"bimbelmaxmonth":"'.$bimbelmaxmonth.'"}';
            echo $out;
        }
    }
    function remove(){
        session_start();
        checklogin();
        $id = $this->uri->segment(3);
        $this->Student->remove($id);
        redirect("../../");
    }
    function save(){
        session_start();
        checklogin();
        $params = $this->input->post();
        $this->Student->save($params);
        redirect("../index");
    }
    function update(){
        session_start();
        checklogin();
        $params = $this->input->post();
        echo $this->Student->update($params);
        redirect("../index");
    }    
}