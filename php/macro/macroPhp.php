<?php
function mRESP_WTF($data = null, $exit = 1){
    $R = new \classesPhp\ClassReturn();
    $rtrn = new \structsPhp\StructReturn();
    if($data==null)$rtrn->data = 'Что-то пошло не так :-(';
    else           $rtrn->data = $data;
    $rtrn->result = 0;
    $rtrn->error = 1;
    $rtrn->response = 'Что-то пошло не так :-(';
    $R->ARet($rtrn, $exit);
}

function mRESP_ADD_ADS_OK($data){
    $R = new \classesPhp\ClassReturn();
    $rtrn = new \structsPhp\StructReturn();
    $rtrn->data = $data;
    $rtrn->result = 1;
    $rtrn->response = 'Объявление добавлено!';
    $R->ARet($rtrn);
}

function mRESP_DATA($data, $res = 1, $err = 0, $response = ''){
    global $G;
    $R = new \classesPhp\ClassReturn();
    $rtrn = new \structsPhp\StructReturn();


    $rtrn->act       = $G->act;
    $rtrn->result    = $res;
    $rtrn->error     = $err;
    $rtrn->response  = $response;
    $rtrn->data      = $data;
    $rtrn->test_data = $G->test_data;
    $R->ARet($rtrn);
}