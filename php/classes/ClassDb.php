<?php
namespace classesPhp;


class ClassDb{
    var $db = null;
    var $last_insert_id;
    var $rowsQt = 0;
    function __construct(){
        $this->db = new \mysqli(DB_HOST,DB_USER, DB_PASS,DB_NAME,DB_PORT);
        $this->db->set_charset('utf8mb4'); //utf8
        $this->db->query('SET NAMES utf8mb4');
    }
    function AQueryToDB($query){
        $res = $this->db->query($query);
        if($res===false){
            mRESP_WTF($this->db->error, 0);
            return 0;
        }
        $this->last_insert_id = $this->db->insert_id;
        $this->rowsQt = $this->db->affected_rows;
        return $res;
    }
    function AGetSingleStringFromDb($query){
        $res = $this->AQueryToDB($query);
        $row = $res->fetch_array();
        return $row;
    }
    function AGetMultiplyDataFromDb($query, $limit=0, $qt=0){
        global $LOG;
        $err = new \structsPhp\StructError();
        if($qt)$query .= " LIMIT ".$limit.', '.$qt;
        $query = str_replace('SELECT','SELECT SQL_CALC_FOUND_ROWS',$query);
        $res = $this->db->query($query);
        if($res){
            $query = "SELECT FOUND_ROWS()";
            $this->row_num = $this->AGetSingleStringFromDb($query);
            $res = $this->ADbResultToArray($res);
            return $res;
        }else{
            $err->error = ERR_DB_QUERY;
            $err->data = $this->db->error;
            $LOG->write($err);
        }
    }
    function ADbResultToArray($result)
    {
        $res_array = array();
        $count = 0;
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $res_array[$count]=$row;
            $count++;
        }
        return $res_array;
    }
    function getMaxId(){
        $query = "SELECT MAX(id) FROM ads";
        $res = $this->AGetSingleStringFromDb($query);
        return $res;
    }
    function ACreateNewLine($tbl){
        $query = "INSERT INTO ".$tbl." VALUES ()";
        $result = $this->AQueryToDB($query);
        if ($result)return $this->last_insert_id;
        else        return null;
    }
    function ASaveDataToDb($data_arr, $tbl, $id = null){
        if(!$id){
            $id = $this->ACreateNewLine($tbl);
        }
        $query = 'UPDATE '.$tbl.' SET ';
        foreach ($data_arr as $key=>$item){
            if(!is_null($item))$query .= $key."= '$item' , ";
        }
        $query = substr($query, 0, (strlen($query) - 2));
        $query .= ' WHERE id='."'$id'";
        $res = $this->AQueryToDB($query);
        $ret = array();
        $ret[STR_ID] = null;
        $ret[STR_DATA] = array();
        if($res){
            $ret[STR_ID]   = $id;
            $ret[STR_DATA] = $res;
        }
        return $ret;
    }
    function AUpdateDataOnDb($tbl, $fields, $filter, $log_data='extends'){
        global $LOG;
        if ((is_null($tbl))||(is_null($fields)))return null;
        $query = "UPDATE ".$tbl." SET ";
        if (is_array($fields)){
            foreach ($fields as $key => $val){
                if(!is_null($val))$query .= $key." = '$val' , ";
            }
            $query = substr($query, 0, (strlen($query) - 2));
        }else{
            mRESP_WTF(__FUNCTION__);
        }
        if($filter){
            if (is_array($filter)){
                $query .= ' WHERE ';
                foreach ($filter as $key => $val){
                    if(!is_null($val))$query .= $key." = '$val' AND ";
                }
                $query = substr($query, 0, (strlen($query) - 4));
            }
        }
        $res = $this->AQueryToDB($query);
        if(!$res){
            $log_note = 'error in '.__FUNCTION__.'. Call from '.$log_data;
            $LOG->write($log_note);
}
        return $res;
    }

    function ASaveLineToDb(){
    echo 123;
}
    function ASaveStructToDb($struct, $tbl, $id = null){
        if(!$id){
            $id = $this->ACreateNewLine($tbl);
        }
        $query = 'UPDATE '.$tbl.' SET ';
        foreach ($struct as $key=>$item){
            if(!is_null($item))$query .= $key."= '$item' , ";
        }
        $query = substr($query, 0, (strlen($query) - 2));
        $query .= ' WHERE id='."'$id'";
        $res = $this->AQueryToDB($query);
        $ret = array();
        $ret[STR_ID] = null;
        $ret[STR_DATA] = array();
        if($res){
            settype($id, "string");
            $ret[STR_ID]   = $id;
            $ret[STR_DATA] = $res;
        }
        return $ret;
    }
    function ALoadStructFromDb($tbl, $id, &$struct, $fields = null){
        global $A_db, $G;
        $flds = '*';
        if($fields){
            $flds = '';
            foreach($fields as $item){
                $flds.= $item.', ';
            }
            $flds = substr($flds, 0, strlen($flds)-2);
        }

        $query = "SELECT $flds FROM $tbl WHERE id='$id'";
        $res = $A_db->AGetSingleStringFromDb($query);
        if($res){
            foreach($struct as $key=>&$item){
                if(isset($res[$key]))$item = $res[$key];
            }
            return $id;
        }
        return 0;
    }
    function loadOpenUserData($user_id, &$user){
        $fields = $this->openUserData();
        $res = $this->ALoadStructFromDb(TBL_USERS, $user_id, $user, $fields);
        return $res;
    }

    function getUserList($idList){
        global $A_db;
        $fields = $this->openUserData();
        $flds = '';
        foreach($fields as $item){
            $flds.= $item.', ';
        }
        $flds = substr($flds, 0, strlen($flds)-2);

        $idL = 'id = ';
        foreach ($idList as $val){
            if ($val)$idL .= $val.' OR id = ';
        }
        $idL = substr($idL, 0, strlen($idL)-9);
        $query = "SELECT $flds FROM users WHERE ".$idL;
        $res = $A_db->AGetMultiplyDataFromDb($query);
        return $res;
    }
    function openUserData(){
        $fields[] = STR_ID;
        $fields[] = STR_LOGIN;
        $fields[] = STR_NAME;
        $fields[] = STR_S_NAME;
        $fields[] = STR_IMG;
        $fields[] = STR_IMG_ICON;
        $fields[] = STR_CREATE_DATE;
        $fields[] = STR_LAST_TIME;
        $fields[] = STR_RATING;
        $fields[] = STR_VOTE_QT;
        $fields[] = STR_ABOUT_USER;
        return $fields;
    }
}

