<?php
namespace classesPhp;
global $A_start;
if($A_start != 444){echo BYBY; exit();}

class ClassPost
{
    private $data;
    function __construct()
    {
        $this->data = array();
        if(!$_POST){
            $inputJSON = file_get_contents('php://input');
            $inputJSON = json_decode($inputJSON,true);
            if($inputJSON) {
                foreach ($inputJSON as $key => $item)
                    $this->data[$key] = $item;

                if(isset($inputJSON[STR_DATA_GROUP]))
                    if (is_array($inputJSON[STR_DATA_GROUP]))
                        foreach ($inputJSON[STR_DATA_GROUP] as $k => $i)
                            $this->data[$k] = $i;
            }
        }else{
            foreach ($_POST as $key => $item){
                if(is_array($item)){
                    $this->data[$key] = array();
                    foreach ($item as $k=>$i){
                        $this->data[$key][$k] = AClearField($i);
                    }
                }else $this->data[$key] = AClearField($item);
            }
        }
    }
    function checkSessionToken(){
        global $S;
        if($S->AGet(STR_WS_TOKEN)!= $this->AGet(STR_WS_TOKEN)){
            mRESP_WTF();
        }
    }
    function AGet($variable)
    {
        if (array_key_exists($variable, $this->data)) {
            return $this->data[$variable];
        } else return null;
    }

    function ASet($variable, $val)
    {
        $this->data[$variable] = $val;
    }

    function AUnSet($variable)
    {
        if (array_key_exists($variable, $this->data)) {
            unset($this->data[$variable]);
            unset($_POST[$variable]);
        }
    }

    function clear()
    {
        $this->data = array();
    }

}

