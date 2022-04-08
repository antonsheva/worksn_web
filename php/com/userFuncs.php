<?php
if($A_start != 444){echo 'byby';exit();}

function userFillData($user_id, \structsPhp\StructUser &$user, $fields = null){
    global $A_db, $G;
    $flds = '*';
    if($fields){
        $flds = '';
        foreach($fields as $item){
            $flds.= $item.', ';
        }
        $flds = substr($flds, 0, strlen($flds)-2);
    }

    $query = "SELECT $flds FROM users WHERE id='$user_id'";
    $res = $A_db->AGetSingleStringFromDb($query);
    if($res){
        foreach($user as $key=>&$item){
            if(isset($res[$key]))$item = $res[$key];
        }
        return $user_id;
    }
    return 0;
}

