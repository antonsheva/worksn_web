<?php
namespace classesPhp;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

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

                if(isset($inputJSON['data_group']))
                    if (is_array($inputJSON['data_group']))
                        foreach ($inputJSON['data_group'] as $k => $i)
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
        if($S->AGet('s_token')!= $this->AGet('s_token')){
            mRESP_WTF('WTF_tk');
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

