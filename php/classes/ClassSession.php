<?php
namespace classesPhp;
global $A_start;
if($A_start != 444){echo BYBY; exit();}

class ClassSession{
    private $data;
    function __construct()
    {
        global  $P;
        $this->data = array();
        foreach ($_SESSION as $variable => $item)
           $this->data[$variable] = $P->AClearField($item);

        $this->createNewSessionToken();
    }
    function AGet($variable){
        if(array_key_exists($variable, $this->data))
            return $this->data[$variable];
        else
            return null;

    }
    function ASet($variable, $value){
        $this->data[$variable] = $value;
        $_SESSION[$variable] = $value;
    }
    function clear(){
        $this->data = array();
        session_unset();
        session_destroy();
    }
    function createNewSessionToken()
    {
        if($this->AGet(STR_WS_TOKEN))return;
        $token = password_hash( WS_TOKEN_FORMULA, PASSWORD_DEFAULT);
        $this->ASet(STR_WS_TOKEN, $token);
    }
}