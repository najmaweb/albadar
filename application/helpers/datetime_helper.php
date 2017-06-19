<?php
function getmontharray($firstmonth,$firstyear,$nextmonth,$nextyear){
    $out = array();
    if($firstyear===$nextyear){
        for($c = $firstmonth;$c<$nextmonth;$c++){
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