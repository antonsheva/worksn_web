<?php
namespace classesPhp;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class ClassReturn
{
    function ARet(\structsPhp\StructReturn $data, $exit = 1){
        global $A_context,  $G;

        $A_context->ACreateContext();
        $data->context = $A_context->data;

//        $ret = 'ClassReturn: ACreateContext[owner] -> '.json_encode($data->context['owner']);
//        echo $ret;
//        exit();

        $data1 = json_encode($data);//
        echo $data1;
        if($exit)exit();
    }
}

