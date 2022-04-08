<?php
namespace classesPhp;
 
class ClassError
{
    function log($data){

    }
    function AError(\structsPhp\StructError $data, $exit = 1){
        $res = json_encode($data);
        echo $res;
        if($exit)exit();
    }
}
