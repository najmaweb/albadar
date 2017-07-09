<?php
class Mcashier extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function getdupsbremain($nis,$year){
        $sql = "select nis,sum(amount)amnt from dupsb group by nis;";
        return "2598000";
    }
    function getdupsbpaid($nis,$year){
        $sql = "select sum(amount)amnt from dupsb a where nis='".$nis."' and year='".$year."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        if($que->num_rows()===0){
            return 0;
        }
        return $que->result()[0]->amnt;
    }
    function gettotaltagihan($nis,$year){
        $sql = "select sum(b.amount)amnt from students a left outer join dupsbgroups b on b.id=a.dupsbgroup_id where nis='".$nis."' and a.year='".$year."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        if($que->num_rows()===0){
            return 0;
        }
        return $que->result()[0]->amnt;
    }
    function getsppmaxyearmonth($nis){
        $sql = "select max(pyear)mpyear,max(pmonth)mpmonth from spp where nis='".$nis."'";
        $ci = & get_instance();
        $res = $ci->db->query($sql);
        $out = $res->result();
        return array("maxyear"=>$out[0]->mpyear,"maxmonth"=>$out[0]->mpmonth);
    }
    function getsppremain($nis){
        $maxym = $this->getsppmaxyearmonth($nis);
        $spp = $this->getspp($nis);
        echo "SPP " . $spp . "<br />";
        if($maxym["maxyear"]===date("Y")){
            if($maxym["maxmonth"]<date("m")){
                $tagihan = $spp*(removezero(date("m"))-removezero($maxym["maxmonth"]));
            }
            else{
                $tagihan = -1;
            }
        }else if($maxym["maxyear"]<date("Y")){
            $count = ((date("Y")-$maxym["maxyear"])*12)-$maxym["maxmonth"] + date("m");
            $COMMENT = "BANYAKNYA BULAN = SELISIH TAHUN x 12, DITAMBAH BULAN SAAT INI DIKURANGI BULAN TERAKHIR PEMBARAYARAN";
            $tagihan = $spp*$count;
        }else{
            echo $maxym["maxyear"] . "<br />";
            echo date("Y") . "<br />";
            $tagihan = -2;
        }
        return array("tagihan"=>$tagihan);
    }
    function getspp($nis){
        $sql = "select nis,amount from students a left outer join sppgroups b on b.id=a.sppgroup_id where nis='".$nis."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result()[0]->amount;
    }
}