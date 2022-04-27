<?php
namespace classesPhp;
global $A_start;
if($A_start != 444){echo BYBY; exit();}

class ClassReturn
{
    function ARet(\structsPhp\StructReturn $data, $exit = 1){
        global $A_context;
        $A_context->ACreateContext();
        $data->context = $A_context->data;
        $data1 = json_encode($data);
        echo $data1;
        if($exit)exit();
    }
}

