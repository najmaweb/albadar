<?php
class Report extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function getdailytransaction(){
        $sql = "select jam,uraian,amount,createuser from ( ";
        $sql.= "select date_format(a.createdate,'%H:%i:%s')jam,concat('Pembayaran SPP ',b.name,' ',c.name) uraian,sum(a.amount)amount,a.createuser ";
        $sql.= "from spp a ";
        $sql.= "left outer join students b on b.nis=a.nis ";
        $sql.= "left outer join grades c on c.id=b.grade_id ";
        $sql.= "where date_format(a.createdate,'%Y-%m-%d')=date_format(now(),'%Y-%m-%d') ";
        $sql.= "group by date_format(a.createdate,'%H:%i:%s'),a.createuser,b.name,c.name ";
        $sql.= "union ";
        $sql.= "select date_format(a.createdate,'%H:%i:%s')jam,concat('Pembayaran Bimbel ',b.name,' ',c.name) uraian,sum(a.amount)amount,a.createuser ";
        $sql.= "from bimbel a ";
        $sql.= "left outer join students b on b.nis=a.nis ";
        $sql.= "left outer join grades c on c.id=b.grade_id ";
        $sql.= "where date_format(a.createdate,'%Y-%m-%d')=date_format(now(),'%Y-%m-%d') ";
        $sql.= "group by date_format(a.createdate,'%H:%i:%s'),a.createuser,b.name,c.name ";
        $sql.= "union ";
        $sql.= "select date_format(a.createdate,'%H:%i:%s')jam,concat('Pembayaran Daftar Ulang / PSB ',b.name,' ',c.name) uraian,sum(a.amount)amount,a.createuser ";
        $sql.= "from dupsb a ";
        $sql.= "left outer join students b on b.nis=a.nis ";
        $sql.= "left outer join grades c on c.id=b.grade_id ";
        $sql.= "where date_format(a.createdate,'%Y-%m-%d')=date_format(now(),'%Y-%m-%d') ";
        $sql.= "group by date_format(a.createdate,'%H:%i:%s'),a.createuser,b.name,c.name ";
        $sql.= "union ";
        $sql.= "select date_format(a.createdate,'%H:%i:%s')jam,concat('Pembayaran Buku ',b.name,' ',c.name) uraian,sum(a.amount)amount,a.createuser ";
        $sql.= "from pembayaranbuku a ";
        $sql.= "left outer join students b on b.nis=a.nis ";
        $sql.= "left outer join grades c on c.id=b.grade_id ";
        $sql.= "where date_format(a.createdate,'%Y-%m-%d')=date_format(now(),'%Y-%m-%d') ";
        $sql.= "group by date_format(a.createdate,'%H:%i:%s'),a.createuser,b.name,c.name ";
        $sql.= ")q order by jam ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function gettransactionperuser($month,$year,$user=null){
        if(is_null($user)){
            $userfilter = " ";
        }else{
            if($user==='all'){
                $userfilter = " ";
            }else{
                $userfilter = "and createuser='".$user."' ";
            }        
        }
        $sql = 'select ord,dt,createuser,sum(amount)amount from (';
        $sql.= 'select date_format(createdate,"%d-%m-%Y") dt,date_format(createdate,"%Y-%m-%d") ord,createuser,sum(amount) amount ';
        $sql.= 'from spp ';
        $sql.= 'where date_format(createdate,"%m-%Y")="'.$month.'-'.$year.'" ';
        $sql.= $userfilter;
        $sql.= 'group by createuser,date_format(createdate,"%d-%m-%Y"),date_format(createdate,"%Y-%m-%d") ';
        $sql.= "union ";
        $sql.= 'select date_format(createdate,"%d-%m-%Y") dt,date_format(createdate,"%Y-%m-%d") ord,createuser,sum(amount) amount ';
        $sql.= 'from bimbel  ';
        $sql.= 'where date_format(createdate,"%m-%Y")="'.$month.'-'.$year.'" ';
        $sql.= $userfilter;

        $sql.= 'group by createuser,date_format(createdate,"%d-%m-%Y"),date_format(createdate,"%Y-%m-%d") ';
        $sql.= "union ";
        $sql.= 'select date_format(createdate,"%d-%m-%Y") dt,date_format(createdate,"%Y-%m-%d") ord,createuser,sum(amount) amount ';
        $sql.= 'from dupsb  ';
        $sql.= 'where date_format(createdate,"%m-%Y")="'.$month.'-'.$year.'" ';
        $sql.= $userfilter;

        $sql.= 'group by createuser,date_format(createdate,"%d-%m-%Y"),date_format(createdate,"%Y-%m-%d") ';
        $sql.= "union ";
        $sql.= 'select date_format(createdate,"%d-%m-%Y") dt,date_format(createdate,"%Y-%m-%d") ord,createuser,sum(amount) amount ';
        $sql.= 'from pembayaranbuku  ';
        $sql.= 'where date_format(createdate,"%m-%Y")="'.$month.'-'.$year.'" ';
        $sql.= $userfilter;

        $sql.= 'group by createuser,date_format(createdate,"%d-%m-%Y"),date_format(createdate,"%Y-%m-%d") ';
        $sql.= ')q group by ord,dt,createuser';
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function getspp($year){
        $sql = "select date_format(createdate,'%d %M %Y') createdate,sum(amount) spp,'Pemb. SPP' subj,createuser from spp ";
        $sql.= "where pyear='".$year."' ";
        $sql.= "group by date_format(createdate,'%d %M %Y'),createuser ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function getspptotal($year){
        $sql = "select sum(amount) spp from spp ";
        $sql.= "where pyear='".$year."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function getbimbel($year){
        $sql= "select date_format(createdate,'%d %M %Y') createdate,sum(amount) spp,'Pemb. Bimbel' subj,createuser from bimbel ";
        $sql.= "where pyear='".$year."' ";
        $sql.= "group by date_format(createdate,'%d %M %Y'),createuser ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function getbimbeltotal($year){
        $sql = "select sum(amount) bimbel from bimbel ";
        $sql.= "where pyear='".$year."' ";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function getrekapsppperkelas(){
        $sql = "select nis,name,sum(jun)jun,sum(jul)jul,sum(ags)ags,sum(sep)sep,sum(okt)okt,sum(nop)nop,sum(des)des,sum(jan)jan,sum(feb)feb,sum(mar)mar,sum(apr)apr,sum(mei)mei ";
        $sql.= "from (select a.id,b.nis,b.name,amount,pmonth,pyear,year ";
        $sql.= ", case a.pmonth when '06' then amount else '0' end jun ";
        $sql.= ", case a.pmonth when '07' then amount else '0' end jul ";
        $sql.= ", case a.pmonth when '08' then amount else '0' end ags ";
        $sql.= ", case a.pmonth when '09' then amount else '0' end sep ";
        $sql.= ", case a.pmonth when '10' then amount else '0' end okt ";
        $sql.= ", case a.pmonth when '11' then amount else '0' end nop ";
        $sql.= ", case a.pmonth when '12' then amount else '0' end des ";
        $sql.= ", case a.pmonth when '01' then amount else '0' end jan ";
        $sql.= ", case a.pmonth when '02' then amount else '0' end feb ";
        $sql.= ", case a.pmonth when '03' then amount else '0' end mar ";
        $sql.= ", case a.pmonth when '04' then amount else '0' end apr ";
        $sql.= ", case a.pmonth when '05' then amount else '0' end mei ";
        $sql.= " from spp a right outer join students b on b.nis=a.nis order by a.nis,a.pmonth)x ";
        $sql.= "group by nis,name";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function getrekapbimbelperkelas(){
        $sql = "select nis,name,sum(jun)jun,sum(jul)jul,sum(ags)ags,sum(sep)sep,sum(okt)okt,sum(nop)nop,sum(des)des,sum(jan)jan,sum(feb)feb,sum(mar)mar,sum(apr)apr,sum(mei)mei ";
        $sql.= "from (select a.id,b.nis,b.name,amount,pmonth,pyear,year ";
        $sql.= ", case a.pmonth when '06' then amount else '0' end jun ";
        $sql.= ", case a.pmonth when '07' then amount else '0' end jul ";
        $sql.= ", case a.pmonth when '08' then amount else '0' end ags ";
        $sql.= ", case a.pmonth when '09' then amount else '0' end sep ";
        $sql.= ", case a.pmonth when '10' then amount else '0' end okt ";
        $sql.= ", case a.pmonth when '11' then amount else '0' end nop ";
        $sql.= ", case a.pmonth when '12' then amount else '0' end des ";
        $sql.= ", case a.pmonth when '01' then amount else '0' end jan ";
        $sql.= ", case a.pmonth when '02' then amount else '0' end feb ";
        $sql.= ", case a.pmonth when '03' then amount else '0' end mar ";
        $sql.= ", case a.pmonth when '04' then amount else '0' end apr ";
        $sql.= ", case a.pmonth when '05' then amount else '0' end mei ";
        $sql.= " from bimbel a right outer join students b on b.nis=a.nis order by a.nis,a.pmonth)x ";
        $sql.= "group by nis,name";
        $ci = & get_instance();
        $que = $ci->db->query($sql);
        return $que->result();
    }
    function getsumrekapbimbelperkelas(){
        $pyear = '2016';
        $sql = "select nis,case pmonth when '06' then amount else 0 end jul,0 agu,0 sep,0 okt,0 nop,0 des,0 jan,0 feb,0 mar,0 apr,0 mei,0 jun from bimbel where pmonth='06' and pyear='".$pyear."' group by nis ";
        $sql.= "union ";
        $sql.= "select nis,case pmonth when '07' then amount else 0 end  jul,0 agu,0 sep,0 okt,0 nop,0 des,0 jan,0 feb,0 mar,0 apr,0 mei,0 jun from bimbel where pmonth='07' and pyear='".$pyear."' group by nis ";
        $sql.= "union ";
        $sql.= "select nis,0 jul,case pmonth when '08' then amount else 0 end agu,0 sep,0 okt,0 nop,0 des,0 jan,0 feb,0 mar,0 apr,0 mei,0 jun from bimbel where pmonth='08' and pyear='".$pyear."' group by nis ";
        $sql.= "union ";
        $sql.= "select nis,0 jul,case pmonth when '09' then amount else 0 end apr,0,0,0,0,0,0,0,0,0,0,0 from bimbel where pmonth='09' and pyear='".$pyear."' group by nis ";
        $sql.= "union ";
        $sql.= "select nis,0,case pmonth when '10' then amount else 0 end apr,0 mei,0 jun,0 jul,0 agu,0 sep,0 okt,0 nop,0 des,0 jan,0 peb,0 mar from bimbel where pmonth='10' and pyear='".$pyear."' group by nis ";
        $sql.= "union ";
        $sql.= "select nis,sum(amount) from bimbel where pmonth='11' and pyear='".$pyear."' group by nis ";
        $sql.= "union ";
        $sql.= "select nis,sum(amount) from bimbel where pmonth='12' and pyear='".$pyear."' group by nis ";
        $sql.= "union ";
        $sql.= "select nis,sum(amount) from bimbel where pmonth='01' and pyear='".$pyear."' group by nis ";
        $sql.= "union ";
        $sql.= "select nis,sum(amount) from bimbel where pmonth='02' and pyear='".$pyear."' group by nis ";
        $sql.= "union ";
        $sql.= "select nis,sum(amount) from bimbel where pmonth='03' and pyear='".$pyear."' group by nis ";
        $sql.= "union ";
        $sql.= "select nis,sum(amount) from bimbel where pmonth='04' and pyear='".$pyear."' group by nis ";
        $sql.= "union ";
        $sql.= "select nis,sum(amount) from bimbel where pmonth='05' and pyear='".$pyear."' group by nis ";
        echo $sql;
    }
    function gettertanggung(){
        $sql = "select mmonth,myear,A.name from(select max(b.pyear)myear,a.name,a.nis from students a left outer join spp b on b.nis=a.nis group by a.name,a.nis)A left outer join  
(select max(pmonth)mmonth,pyear,a.name,a.nis from students a left outer join spp b on b.nis=a.nis group by pyear,a.name,a.nis) B on B.nis=A.nis and A.myear=B.pyear";


$sql = "select B.mmonth,A.myear,A.name from(select max(b.pyear)myear,a.name,a.nis from students a left outer join bimbel b on b.nis=a.nis group by a.name,a.nis)A left outer join  
(select max(pmonth)mmonth,pyear,a.name,a.nis from students a left outer join bimbel b on b.nis=a.nis group by pyear,a.name,a.nis) B on B.nis=A.nis and A.myear=B.pyear";


$sql = "select case when mmonth is null then timestampdiff(month,'2014-7-1',curdate()) else timestampdiff(month,concat(A.myear,'-',B.mmonth,'-','01'),curdate()) end totmonth,case when B.mmonth is null then '-' else concat(A.myear,'-',B.mmonth) end terakhirbayar,A.name from(select max(b.pyear)myear,a.name,a.nis from students a left outer join bimbel b on b.nis=a.nis group by a.name,a.nis)A left outer join   (select max(pmonth)mmonth,pyear,a.name,a.nis from students a left outer join bimbel b on b.nis=a.nis group by pyear,a.name,a.nis) B on B.nis=A.nis and A.myear=B.pyear;
";
    }
}