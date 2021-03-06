<?php
namespace classesPhp;
global $A_start;

use structsPhp\dbStruct\tblDiscus;

if($A_start != 444){echo BYBY; exit();}

class ClassOwner{
    var $owner = null;
    var $owner_id = null;
    var $discus;
    function __construct()
    {
        $this->owner = new \structsPhp\StructUserShort();
        $this->discus = new \structsPhp\dbStruct\tblDiscus();
        $this->AGetOwner();
    }
    function AGetOwner(){
        global $P, $G, $A_db;
        $ownerId = $P->AGet(STR_OWNER_ID);
        if(!$ownerId)$ownerId = $G->owner_id;
        if($ownerId){
            $res = $A_db->loadOpenUserData($ownerId, $this->owner);
            if ($res){

                $G->owner = $this->owner;
                $G->owner_id = $this->owner->id;
                $G->owner->bw_status = BW_STATUS_EMPTY;
            }            
        }
    }
}