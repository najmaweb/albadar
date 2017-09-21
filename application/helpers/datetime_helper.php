<?php
function getmontharray($firstmonth,$firstyear,$nextmonth,$nextyear){
    $out = array();
    if($firstyear===$nextyear){
        for($c = $firstmonth;$c<=$nextmonth;$c++){
            array_push($out,addzero($c).$firstyear);
        }
    }
    if($nextyear>$firstyear){
        for($c = $firstmonth;$c<=12;$c++){
            array_push($out,addzero($c).$firstyear);
        }
        for($y=$firstyear;$y<$nextyear;$y++){
            for($c = 1;$c<=12;$c++){
                array_push($out,addzero($c).$y);
            }
        }
        for($c = 1;$c<=$nextmonth;$c++){
            array_push($out,addzero($c).$nextyear);
        }
    }
    return $out;
}
function addzero($str){
    for($c = strlen($str);$c<2;$c++){
        $str='0'.$str;
    }
    return $str;
}
function convertdateformat($val,$formatbefore,$formatafter){
    $out = "";
    switch($formatbefore){
        case "dd/mm/yyyy":
            $arr = explode("/",$val);
            $year = $arr[2];
            $month = $arr[1];
            $date = $arr[0];
        break;
        case "yyyy-mm-dd":
            $arr = explode("-",$val);
            $year = $arr[0];
            $month = $arr[1];
            $date = $arr[2];
        break;
    }
    switch($formatafter){
        case "yyyy-mm-dd":
        $out = $year."-".$month."-".$date;
        break;
        case "dd/mm/yyyy":
        $out = $date."/".$month."/".$year;
        break;
    }
    return $out;
}
function removezero($str,$length=2){
    $out = "";
    $found = false;
    for($c=0;$c<$length;$c++){
        if(substr($str,$c,1)!=="0"){
            $found = true;
        }
        if($found){
            $out.=substr($str,$c,1);
        }
    }
    return $out;
}
function getperiodmonths(){
    return array(
        "7"=>"Juli","8"=>"Agustus","9"=>"September","10"=>"Oktober","11"=>"September","12"=>"Desember","1"=>"Januari","2"=>"Februari","3"=>"Maret","4"=>"April","5"=>"Mei","6"=>"Juni"
    );
}