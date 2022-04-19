<?php
namespace classesPhp;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class ClassSession{
    private $data;

    function __construct()
    {
        $this->data = array();
        foreach ($_SESSION as $variable => $item):
           $this->data[$variable] = AClearField($item);
        endforeach;
        $this->createNewSessionToken();
    }
    function AGet($variable){
        if(array_key_exists($variable, $this->data)){
            return $this->data[$variable];
        }else return null;
    }
    function ASet($variable, $value){
        $this->data[$variable] = $value;
        $_SESSION[$variable] = $value;
    }
    function clear(){
        $this->data = array();

        session_unset();
        session_destroy();
//        $_SESSION = array();
    }
    function createNewSessionToken()
    {
        if($this->AGet('ws_token'))return;
        $time = hrtime(true);
        $token = password_hash($time . 'dsafvgds', PASSWORD_DEFAULT);
        $this->ASet('ws_token', $token);
    }
}