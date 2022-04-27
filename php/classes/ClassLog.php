<?php
namespace classesPhp;
global $A_start;
if($A_start != 444){echo BYBY; exit();}

class ClassLog
{
    function write($data){
        global $G;
        $file = fopen(FILE_MY_LOG, 'a');
        $note = $G->date.' - '.$data;
        fwrite($file,$note."\r\n");
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
        }catch (\Exception $e){

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
        }catch (\Exception $e){

        }
    }
}