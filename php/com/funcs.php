<?php

function AClearField($str){    //Clear fields from except chars
    global $A_db, $LOG;
    $str = str_replace("'","`",$str);
    $str = str_replace("\"","`",$str);
    try{
        $str = $A_db->db->real_escape_string($str);
    }catch (Exception $e){
        $LOG->write($e);
        mRESP_WTF();
    }

    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    $str = trim($str);
    return $str;
}

function cleanArray($dataArr){
    $data = (array($dataArr));
    $res = array();
    foreach ($data as $key=>$item){
        if ($item == null)continue;
        if ($item == 'null')continue;
        if ($item == 'NULL')continue;
        if ($item == '')continue;
        $res[$key] = $item;
    }
    return $res;
}

function cleanArray1($dataArr, $res){
    foreach ($dataArr as $key=>$item){
        if ($item == null)continue;
        if ($item == 'null')continue;
        if ($item == 'NULL')continue;
        if ($item == '')continue;

        if (is_array($item)){
            $res[$key] = array();
            cleanArray1($item,$res[$key]);
        }
        $res[$key] = $item;
    }
    return $res;
}

function arrayToArrayNotNull($src, $dest){
    $arr_src = array();
    foreach($src as $key=>$item)
        $arr_src[$key] = $item;
    foreach($dest as $key=> &$item)
        if (array_key_exists($key, $arr_src))
            if (!is_null($arr_src[$key])) $item = $arr_src[$key];
}
function arrayToArray($src, $dest){
    $arr_src = array();
    foreach($src as $key=>$item)
        $arr_src[$key] = $item;
    foreach($dest as $key=> &$item)
        if (array_key_exists($key, $arr_src))
            if ($arr_src[$key]) $item = $arr_src[$key];
}
function getPostData(&$data){
    global $P;
    foreach ($data as $key=> &$item)
        $item = $P->AGet($key);
}
function shutdownFunc() {
    $error = error_get_last();
    if (is_array($error) && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        // очищаем буфер вывода (о нём мы ещё поговорим в последующих статьях)
        mRESP_WTF();
        while (ob_get_level()) {
            ob_end_clean();
        }
        // выводим описание проблемы

    }
}
function getToken(){
    global $S, $AC_img;
    $AC_img->removeOldImgsFromSession();
    mRESP_DATA('Ok');
}

function getEnvData(){
    mRESP_DATA(0);
}
function getSettingPageData(){
    mRESP_DATA(0);
}
function refreshSession(){
    mRESP_DATA(0);
}

function saveCrashDataToFile(){
    global $P, $G;
    try{

        $file = fopen('log_crash.txt', 'a');
        $content = $P->AGet('content');
        $content = $G->date.' : user_id -> '.$G->user->id.'; user_login -> '.$G->user->login."\r\n"
                  .$content."\r\n"."\r\n";
        fwrite($file,$content);
        fclose($file);
        mRESP_DATA('Crash data was saved');
    }catch (Exception $e){

    }
}
function saveLogActivityDataToFile(){
    global $P, $G;
    try{

        $file = fopen('my_log/log_activity.txt', 'a');
        $content = $P->AGet('content');
        $content = $G->date.' : user_id -> '.$G->user->id.'; user_login -> '.$G->user->login."\r\n"
            .$content."\r\n"."\r\n";
        fwrite($file,$content);
        fclose($file);
        mRESP_DATA('Log activity data was saved');
    }catch (Exception $e){

}
}

function saveLogServiceDataToFile(){
    global $P, $G;
    try{

        $file = fopen('my_log/log_service.txt', 'a');
        $content = $P->AGet('content');
        $content = $G->date.' : user_id -> '.$G->user->id.'; user_login -> '.$G->user->login."\r\n"
            .$content.PHP_EOL.PHP_EOL.PHP_EOL;
        fwrite($file,$content);
        fclose($file);
        mRESP_DATA('Log service data was saved');
    }catch (Exception $e){

    }
}
