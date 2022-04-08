<?php
namespace classesPhp;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class ClassLog
{
    function write($data){
        global $A_file_log, $G;
        $note = $G->date.' - '.$data;
        fwrite($A_file_log,$note."\r\n");
    }
}