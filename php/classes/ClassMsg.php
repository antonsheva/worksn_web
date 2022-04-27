<?php
namespace classesPhp;
global $A_start;

use structsPhp\dbStruct;
use structsPhp\StructAds;
use structsPhp\StructMsg;
use structsPhp\StructMsgShort;
use structsPhp\StructUser;
use structsPhp\StructUserShort;

if($A_start != 444){echo 'byby';exit();}

class ClassMsg{
    var $msgDb;
    var $msgFull;
    var $discusDb;

    function __construct(){
        $this->adsDb      = new \structsPhp\dbStruct\tblAds();
        $this->msgDb    = new \structsPhp\dbStruct\tblMsg();
        $this->msgFull  = new \structsPhp\StructMsg();
        $this->discusDb = new \structsPhp\dbStruct\tblDiscus();
        getPostData($this->msgDb);
        getPostData($this->msgFull);
        getPostData($this->discusDb);
    }
    function AAddMsg(){
        global $G, $A_db, $S, $DIR, $AC_img;
        $msgDb    = new \structsPhp\dbStruct\tblMsg();
        $msgFull  = new \structsPhp\StructMsg();
        $discusDb = new \structsPhp\dbStruct\tblDiscus();
        getPostData($msgDb);
        getPostData($msgFull);
        getPostData($discusDb);

        if($msgDb->sender_id && $msgDb->consumer_id && $msgDb->ads_id){
            if($msgDb->sender_id == $G->user->id){
                $discusDb = $this->getDiscus();
                if($msgDb->consumer_id==$msgDb->sender_id){//при посылке нескольких смс подряд
                    if($discusDb->speaker_1 != $msgDb->sender_id)$msgDb->consumer_id = $discusDb->speaker_1;
                    if($discusDb->speaker_2 != $msgDb->sender_id)$msgDb->consumer_id = $discusDb->speaker_2;
                }
                if($S->AGet(STR_TMP_IMG)){
                    $imgPath = $AC_img->saveImg($S->AGet(STR_TMP_IMG),$DIR->msg_imgs);
                    $msgDb->img      = $imgPath[STR_IMG];
                    $msgDb->img_icon = $imgPath[STR_IMG_ICON];
                }
                $msgDb->create_date = $G->date;
                $msgDb->discus_id = $discusDb->id;
                $msgDb->rmv_1 = $this->checkBwList($msgDb->consumer_id);
                $msgDb->id = $A_db->ASaveStructToDb($msgDb,TBL_MSG)[STR_ID];
                $this->setViewedDiscus($discusDb->id);
                $G->targetMsg = $msgDb;
                $AC_img->removeOldImgsFromSession();
                mRESP_DATA(0);
            }else mRESP_WTF();
        }else mRESP_WTF();
    }
    function checkBwList($consumerId){
        global $A_db, $G;
        $query = "SELECT ban_list FROM users WHERE id=$consumerId";
        $res = $A_db->AGetSingleStringFromDb($query);
        if ($res){
            $banList = $res[STR_BAN_LIST];
            if (strlen($banList)>0){
                $banList = explode("_", $banList);
                if (in_array($G->user_id, $banList))return $consumerId;
            }else{
                return 0;
            }
        }
        return 0;
    }
    function getDiscus(){
        global $A_db, $LOG;
        $msgDb    = $this->msgDb;
        $discusDb = $this->discusDb;
        if($msgDb->sender_id && $msgDb->consumer_id && $msgDb->ads_id){
            $sender_id   = $msgDb->sender_id;
            $consumer_id = $msgDb->consumer_id;
            $ads_id      = $msgDb->ads_id;
            $discus_id   = $msgDb->discus_id;
            if($discus_id){
                 if(!$A_db->ALoadStructFromDb(TBL_DISCUS,$discus_id,$discusDb))$LOG->write('ERROR GET DISCUS; ID -> '.$discus_id);
            }else{
                $discusDb->speaker_1 = $sender_id;
                $discusDb->speaker_2 = $consumer_id;
                $discusDb->ads_id    = $ads_id;
                $query = "SELECT * FROM discus WHERE ((((speaker_1='$sender_id')AND(speaker_2='$consumer_id'))OR
                                                       ((speaker_2='$sender_id')AND(speaker_1='$consumer_id')))
                                                    AND (ads_id='$ads_id'))";
                $res = $A_db->AGetSingleStringFromDb($query);
                if($res){
                    arrayToArrayNotNull($res,$discusDb);
                    $msgDb->discus_id = $discusDb->id;
                }else {
                    $discusDb->id = $A_db->ASaveStructToDb($discusDb, TBL_DISCUS)[STR_ID];
                }
            }
            return $discusDb;
        }
        return 0;
    }
    function getNewMsg(){
        global $G;
        $msgStatus = MSG_STATUS_READ;
        if(!$G->user_id)mRESP_WTF();
        $query = "SELECT * FROM msg WHERE ((id IN (SELECT  MAX(id) FROM msg GROUP BY discus_id))
                                      AND (view < '$msgStatus') AND (consumer_id = '$G->user_id')) AND
                                          ((rmv_1 != '$G->user_id')AND(rmv_2 != '$G->user_id'))
                           ORDER BY id DESC";
        $this->fillMsgGroupStruct($query);
    }
    function getAllMsg()
    {
        global $G;
        if (!$G->user_id) mRESP_WTF();
        $query = "SELECT * FROM msg WHERE ((id IN (SELECT  MAX(id) FROM msg WHERE (
                                          ((consumer_id = '$G->user_id')OR(sender_id = '$G->user_id'))AND
                                                      ((rmv_1 != '$G->user_id')AND(rmv_2 != '$G->user_id'))) GROUP BY discus_id)))
                                      ORDER BY id DESC ";
        $this->fillMsgGroupStruct($query);
    }
    function getUserMsg(){
        global $G, $P;
        $speakerId = $P->AGet(STR_SPEAKER_ID);
        if (!$G->user_id || !$speakerId) mRESP_WTF();
        $query = "SELECT * FROM msg WHERE ((id IN (SELECT  MAX(id) FROM msg WHERE (
                                          (((consumer_id = '$G->user_id')AND(sender_id = '$speakerId')) OR
                                           ((sender_id = '$G->user_id')AND(consumer_id = '$speakerId')))
                                          AND 
                                          ((rmv_1 != '$G->user_id')AND(rmv_2 != '$G->user_id'))) GROUP BY discus_id)))
                                          ORDER BY id DESC ";
        $this->fillMsgGroupStruct($query);
    }


    function fillMsgGroupStruct($query){
        global $A_db, $G, $P;
        $data = array();
        $ads = new dbStruct\tblAds();
        $flds_user = array(STR_LOGIN, STR_RATING, STR_ID, STR_IMG);
        $flds_ads = array(STR_DESCRIPTION, STR_COST, STR_ID, STR_CATEGORY);
        $res = $A_db->AQueryToDB($query);
        if ($res) {
            $res = $A_db->ADbResultToArray($res);
            if (count($res)){
                foreach ($res as $key => $item) {
                    $msg = new StructMsg();
                    $sender = new StructUserShort();
                    $consumer = new StructUserShort();
                    $A_db->loadOpenUserData($item[STR_SENDER_ID], $sender);
                    $A_db->loadOpenUserData($item[STR_CONSUMER_ID], $consumer);
                    $A_db->ALoadStructFromDb(TBL_ADS, $item[STR_ADS_ID], $ads, $flds_ads);
                    arrayToArrayNotNull($item, $msg);
                    $msg->sender_id     = $sender->id;
                    $msg->sender_login  = $sender->login;
                    $msg->sender_rating = $sender->rating;
                    $msg->sender_img    = $sender->img_icon;

                    $msg->consumer_id     = $consumer->id;
                    $msg->consumer_login  = $consumer->login;
                    $msg->consumer_rating = $consumer->rating;
                    $msg->consumer_img    = $consumer->img_icon;

                    $this->fillSpeakerData($msg);

                    $msg->ads_id = $ads->id;
                    $msg->ads_description = $ads->description;
                    $msg->cost = $ads->cost;
                    $msg->ads_category = $ads->category;

                    $data[] = $msg;
                }
                $G->messages = $data;
                mRESP_DATA(0, count($data));
            }else{
                $data = STRING_NO_MSG;
                if($P->AGet(STR_ACT) == ACT_GET_NEW_MSG)
                    $data = STRING_NO_NEW_MSG;
                mRESP_DATA($data, 0);
            }
        }else {
            mRESP_WTF();
        }


    }
    function getDiscusForAds(){
        $discus = $this->getDiscus();
        if($discus)$this->getMsgChain($discus->id);
        mRESP_DATA(0,0);
    }
    function getMsgChain($discusId = null){
        global $A_db, $G, $P;
        $discus  = new dbStruct\tblDiscus();
        $ads     = new StructAds();
        $owner   = new StructUserShort();
        $speaker = new StructUserShort();
        $data = array();

        if (!$discusId)
            $discusId = $P->AGet(STR_DISCUS_ID);
        if(!$G->user->id || !$discusId)mRESP_WTF();

        $res = $A_db->ALoadStructFromDb(TBL_DISCUS, $discusId, $discus);
        if(!$res)mRESP_DATA(0);

        $res = $A_db->ALoadStructFromDb(TBL_ADS, $discus->ads_id, $ads);
        if(!$res)mRESP_DATA(0);


        $speakerId = $this->getSpeakerId($discus->speaker_1, $discus->speaker_2);
        $res =  $A_db->loadOpenUserData($speakerId, $speaker);
        if (!$res)mRESP_DATA(0);

        if ($ads->user_id == 2)$res = $A_db->loadOpenUserData($speakerId, $owner);
        else                   $res = $A_db->loadOpenUserData($ads->user_id, $owner);
        if(!$res)mRESP_DATA(0);

        $query = "SELECT * FROM msg WHERE ((discus_id = '$discusId')AND(rmv_1 != '$G->user_id')AND(rmv_2 != '$G->user_id')) ORDER BY id DESC LIMIT 100";
        $res = $A_db->AGetMultiplyDataFromDb($query);
        if($res){
            $this->setViewedDiscus($discusId);
            foreach ($res as $key=>$item){
                $msg = new StructMsgShort();
                arrayToArrayNotNull($item, $msg);
                $msg->sender_id = $item[STR_SENDER_ID];
                $msg->discus_id = $discusId;
                $data[] = $msg;
            }
        }
        $G->discus = $discus;
        $G->owner = $owner;
        $G->speaker = $speaker;
        $G->messages = $data;
        $G->targetAds = $ads;
        mRESP_DATA(0, count($data));
    }
    function fillSpeakerData(StructMsg &$msg){
        global $G;
        if($G->user_id == $msg->sender_id){
            $msg->speaker_id     = $msg->consumer_id;
            $msg->speaker_login  = $msg->consumer_login;
            $msg->speaker_rating = $msg->consumer_rating;
            $msg->speaker_img    = $msg->consumer_img;
        }else{
            $msg->speaker_id     = $msg->sender_id;
            $msg->speaker_login  = $msg->sender_login;
            $msg->speaker_rating = $msg->sender_rating;
            $msg->speaker_img    = $msg->sender_img;
        }
    }
    function getSpeakerId($speaker1, $speaker2){
        global $G;
        if ($speaker1 == $G->user->id){
           return $speaker2;
        }else{
            return $speaker1;
        }
    }
    function setViewedDiscus($discusId){
        global $G, $A_db;
        $fltr[STR_DISCUS_ID] = $discusId;
        $fltr[STR_CONSUMER_ID] = $G->user_id;
        $flds[STR_VIEW] = 2;
        $A_db->AUpdateDataOnDb(TBL_MSG, $flds, $fltr);
    }
    function searchOwner(StructMsg $msg){
        global $G, $O;
        $owner_id = null;
        if($msg->sender_id && ($msg->sender_id != $G->user_id))$owner_id = $msg->sender_id;
        if($msg->consumer_id && ($msg->consumer_id != $G->user_id))$owner_id = $msg->consumer_id;
        if(($msg->consumer_id==$G->user_id) && ($msg->sender_id == $G->user_id))$owner_id = $G->user_id;
        if($owner_id){
            $G->owner_id = $owner_id;
            $O->AGetOwner();
        }else{
            mRESP_WTF();
        }
    }
    function checkNewMsg(){
        global $A_db,$G;
        $msgStatus = MSG_STATUS_NOT_DELIVER;
        if ($G->user_id){
            $query = "SELECT id FROM msg WHERE 
                      (consumer_id = '$G->user_id' AND view ='$msgStatus' AND ((rmv_1 != '$G->user_id')AND(rmv_2 != '$G->user_id'))) LIMIT 1";
            $res = $A_db->AGetMultiplyDataFromDb($query);
            if ($res)mRESP_DATA(0, 1);
        }
        mRESP_DATA(0, 0);
    }
    function rmvMsg(){
        global $A_db, $G;
        if(!$G->user_id || !$this->msgDb->id)mRESP_WTF();
        $fields[] = STR_SENDER_ID;
        $fields[] = STR_CONSUMER_ID;
        $fields[] = STR_RMV_1;
        $fields[] = STR_RMV_2;
        $res = $A_db->ALoadStructFromDb(TBL_MSG, $this->msgDb->id, $this->msgDb, $fields);
        if($res){
            if  (($this->msgDb->sender_id != $G->user_id)&&
                 ($this->msgDb->consumer_id != $G->user_id))
                        mRESP_WTF();
            if  ((($this->msgDb->rmv_1 != $G->user_id)&& $this->msgDb->rmv_1)&&
                 (($this->msgDb->rmv_2 != $G->user_id)&& $this->msgDb->rmv_2))
                        mRESP_WTF();
            if(($this->msgDb->rmv_1 == $G->user_id)||($this->msgDb->rmv_2 == $G->user_id))
                        mRESP_DATA(1);
            if(!$this->msgDb->rmv_1){
                $this->msgDb->rmv_1 = $G->user_id;
                $fld[STR_RMV_1] = $G->user_id;
            }else{
                $this->msgDb->rmv_2 = $G->user_id;
                $fld[STR_RMV_2] = $G->user_id;
            }
            $fltr[STR_ID] = $this->msgDb->id;
            $res =  $A_db->AUpdateDataOnDb(TBL_MSG, $fld, $fltr);
            if($res)mRESP_DATA(0);
        }
        mRESP_WTF();
    }
    function rmvDiscus(){
        global $A_db, $G;
        if(!$G->user_id || !$this->discusDb->id) mRESP_WTF();

        $fields[] = STR_SPEAKER_1;
        $fields[] = STR_SPEAKER_2;
        $res = $A_db->ALoadStructFromDb(TBL_DISCUS, $this->discusDb->id, $this->discusDb, $fields);
        if($res){
            $discus_id = $this->discusDb->id;
            if  (($this->discusDb->speaker_1 != $G->user_id)&&
                 ($this->discusDb->speaker_2 != $G->user_id))
                    mRESP_WTF();

            $msgStatus = MSG_STATUS_NOT_DELIVER;
            $query = "UPDATE msg SET rmv_1='$G->user_id' WHERE (rmv_1='$msgStatus' AND rmv_2 != '$G->user_id' AND discus_id = '$discus_id')";
            $res = $A_db->AQueryToDB($query);
            if(!$res) mRESP_WTF();
            $query = "UPDATE msg SET rmv_2='$G->user_id' WHERE (rmv_2='$msgStatus' AND rmv_1 != '$G->user_id' AND discus_id = '$discus_id')";
            $res = $A_db->AQueryToDB($query);
            if(!$res) mRESP_WTF();
            mRESP_DATA(0);
        }
        mRESP_WTF();
    }
}