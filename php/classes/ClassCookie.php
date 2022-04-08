<?php
namespace classesPhp;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class ClassCookie{
    function ASet($variable, $val, $time=10000000){
        setcookie($variable, $val, time()+$time, "", "", false, true);
    }
    function AGet($variable){
        if(isset($_COOKIE[$variable]))return $_COOKIE[$variable];
        else return false;
    }
    function AUnSet($variable){
        if(isset($_COOKIE[$variable]))setcookie($variable, "", time() - 3600);
    }
    function AClear(){
        setcookie(session_name(), session_id(), time()-3600);
        foreach ($_COOKIE as $key=>$item){
            setcookie($key, "", time() - 3600);
        }
    }
}