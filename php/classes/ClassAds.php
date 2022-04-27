<?php
namespace classesPhp;
global $A_start;
use structsPhp\dbStruct\tblAds;
use structsPhp\G;
use structsPhp\StructAds;
use structsPhp\StructCllct;
use structsPhp\StructUser;
use structsPhp\TxtData;

if($A_start != 444){echo 'byby';exit();}

class ClassAds{
    var $adDb;
    var $adFull;
    var $cllct;
    var $crd;
    var $searchQuery = null;
    public function __construct()
    {
        $this->cllct  = new \structsPhp\StructCllct();
        $this->adDb   = new \structsPhp\dbStruct\tblAds();
        $this->adFull = new \structsPhp\StructAds();
        $this->crd    = new \structsPhp\StructCoordinates();
        getPostData($this->adDb);
        getPostData($this->adFull);
        $this->checkPostData(STR_GET_ADS);
        $this->getTargetAds();

    }
    function getSearchQuery(){
        $tmp = $this->cllct->search_phrase;
        $tmp = substr($tmp,0,100);
        $this->searchQuery = '';
        if($tmp){
            $tmpArr =  explode(' ', $tmp);
            $tmpArr = array_slice($tmpArr, 0, 9);
            foreach($tmpArr as $key=>$item):
                if(strlen($item)>10){
                    $item = substr($item,0,strlen($item)-4);
                }
                elseif(strlen($item)>8){
                    $item = substr($item,0,strlen($item)-2);
                }
                $this->searchQuery.= " description LIKE '%$item%'";
                if($key < (count($tmpArr)-1)) $this->searchQuery .=" AND ";
            endforeach;
        }
    }
    function getTargetAds(){
        global $P, $A_db, $G;
        $ads_id = $P->AGet(STR_ADS_ID);
        if(!$ads_id)$ads_id = $G->ads_id;
        if($ads_id)$A_db->ALoadStructFromDb('ads', $ads_id, $G->targetAds);
        if($G->targetAds->user_id)$G->owner_id = $G->targetAds->user_id;
        $G->targetAds->user_login = $G->owner->login;
        $G->targetAds->user_rating = $G->owner->rating;
    }

    function ASetAdsType($type){
        global $S, $G;
        if($type){
            $G->ads_type = $type;
            $S->ASet(STR_ADS_TYPE, $type);
        }
    }
    function AAddAds(){
        global $P,$G, $A_db, $AC_img;

        $lifetime = $this->getLifeTime();
        $user_id = $P->AGet(STR_USER_ID);
        if($user_id == $G->user->id){

            if($P->AGet(STR_EDIT)){
               $G->ads_id = $P->AGet(STR_ID);
               $this->getTargetAds();
               if (!$G->targetAds->user_id            )mRESP_WTF();
               if ( $G->targetAds->user_id != $user_id)mRESP_WTF();
            }

            $this->checkTimeRange();
            if($this->adDb->img)$this->saveImgs();
            $this->adDb->create_date = $G->date;
            $this->adDb->create_time = $G->time;
            $this->adDb->lifetime = $lifetime;
            $this->adDb->remove = 0;
            $this->adDb->remote_addr = $_SERVER[STR_REMOTE_ADDR];
            $this->adDb->id = $A_db->ASaveDataToDb($this->adDb,TBL_ADS, $this->adDb->id)[STR_ID];
            if($this->adDb->id){
                $this->adFull->user_login = $G->user->login;
                $this->adFull->user_img   = $G->user->img;
                arrayToArrayNotNull($this->adDb, $this->adFull);
                $G->targetAds = $this->adFull;
                $AC_img->removeOldImgsFromSession();
                mRESP_DATA(STRING_ADS_WAS_ADD);

                $_SERVER[STR_REMOTE_ADDR];
            }
            else    mRESP_WTF();
        }else{
            mRESP_WTF();
        }
    }
    function checkTimeRange(){
        $err = 0;
        if (($this->adDb->hour_start == 0)&&($this->adDb->hour_stop == 0)&&
            ($this->adDb->min_start == 0)&&($this->adDb->min_stop == 0))return;

        if (($this->adDb->hour_start > 23)||($this->adDb->hour_start < 0))$err = 1;
        if (($this->adDb->hour_stop > 23)||($this->adDb->hour_stop < 0))$err = 1;
        if (($this->adDb->min_start > 59)||($this->adDb->min_start < 0))$err = 1;
        if (($this->adDb->min_stop > 59)||($this->adDb->min_stop < 0))$err = 1;

        if (($this->adDb->hour_start == $this->adDb->hour_stop)&& ($this->adDb->min_start == $this->adDb->min_stop))$err = 1;
    

        if ($err){
            $this->adDb->hour_start = null;
            $this->adDb->hour_stop = null;
            $this->adDb->min_start = null;
            $this->adDb->min_stop = null;
        }
    }
    function saveImgs(){
        global $AC_img, $DIR, $P;
        if ($P->AGet(STR_EDIT))$this->removeOldImgs();
        try{
            $arr = explode(',', $this->adDb->img);
        }catch (\Exception $e){
            mRESP_WTF();
            $arr = null;
        }
        if(is_array($arr)){
            $this->adDb->img = '';
            foreach ($arr as $item){
                if($item && ($item !='')){
                    $imgPath = $AC_img->saveImg($DIR->tmp_img.$item,$DIR->ads_imgs);
                    $this->adDb->img     .= $imgPath[STR_IMG].',';
                    $this->adDb->img_icon.= $imgPath[STR_IMG_ICON].',';
                }
            }
            $tmpStr = $this->adDb->img;
            $tmpStr = substr($tmpStr, 0, strlen($tmpStr)-1);
            $this->adDb->img = $tmpStr;

            $tmpStr = $this->adDb->img_icon;
            $tmpStr = substr($tmpStr, 0, strlen($tmpStr)-1);
            $this->adDb->img_icon = $tmpStr;
        }
    }
    function removeOldImgs(){
        global $P, $AC_img;
        $errCnt = 0;
        $errFiles = '';
        $res = array();
        if ($P->AGet(STR_OLD_IMGS)){
            $fileList = $P->AGet(STR_OLD_IMGS);
            $res = $AC_img->removeFileList($fileList, 0);
            $errCnt += $res['errCnt'];
            $errFiles.= $res['errFiles'];
        }
        if ($P->AGet(STR_OLD_IMGS)){
            $fileList = $P->AGet(STR_OLD_IMGS_ICON);
            $AC_img->removeFileList($fileList, 0);
            $errCnt += $res['errCnt'];
            $errFiles.= $res['errFiles'];
        }
        $ret['errCnt'] = $errCnt;
        $ret['errFiles'] = $errFiles;
        return $ret;
    }
    function editAds(){
        global $AC_img, $P, $G;
        $adsId   = $P->AGet(STR_ADS_ID);
        $img     = $P->AGet(STR_IMG);
        $imgIcon = $P->AGet(STR_IMG_ICON);
        if (!$G->targetAds->user_id)mRESP_WTF();
        if ($G->targetAds->user_id != $G->user_id)mRESP_WTF();
        if ($img){
            $res = $AC_img->copyImgsToTmpFolder($img, $imgIcon);
            $G->img_list = $res[STR_IMG_LIST];
            mRESP_DATA(0, $res[STR_IMG_CNT]);
        }
        mRESP_DATA(0);
    }
    function updateAds(){
        global $P,$G, $A_db;
        $user_id = $P->AGet(STR_USER_ID);
        $ads_id  = $P->AGet(STR_ADS_ID);
        $lifetime = $this->getLifeTime();
        if(($user_id === $G->user->id) && $ads_id && ($user_id === $this->adDb->user_id)){
            $this->adDb->img = $G->user->img;
            $this->adDb->create_date = $G->date;
            $this->adDb->create_time = $G->time;
            $this->adDb->lifetime = $lifetime;
            $this->adDb->remove = 0;
            $this->adDb->id = $A_db->ASaveDataToDb($this->adDb,TBL_ADS, $ads_id)[STR_ID];
            if($this->adDb->id){
                $this->adFull->user_login = $G->user->login;
                $this->adFull->img        = $G->user->img;
                arrayToArrayNotNull($this->adDb, $this->adFull);
                $G->targetAds = $this->adFull;
                mRESP_DATA(0);
            }
        }
        mRESP_WTF();
    }
    function checkCollectionParameters(){
        global $P, $G;
        if(is_array($P->AGet(STR_CLLCT))){
            arrayToArray($P->AGet(STR_CLLCT), $this->cllct);
            if($this->cllct->ads_type)
                switch ($this->cllct->ads_type){
                    case TYPE_WORKER   : $this->cllct->ads_type = TYPE_WORKER;    break;
                    case TYPE_EMPLOYER : $this->cllct->ads_type = TYPE_EMPLOYER;  break;
                    default            : $this->cllct->ads_type = 0;
                }
            if(!(intval($this->cllct->user_id)))$this->cllct->user_id = null;
            $this->cllct->remove = intval($this->cllct->remove);
            $this->cllct->active = intval($this->cllct->active);
        }else{
            $this->cllct->ads_type = 0;
            $this->cllct->user_id = null;
            $this->cllct->remove = 0;
            $this->cllct->search_phrase = null;
        }
        if ($this->cllct->search_phrase)$this->getSearchQuery();
    }
    function AGetAdsCollection(){
        global $A_db, $G;

        $this->crd->min_x = round($this->crd->min_x,4);
        $this->crd->max_x = round($this->crd->max_x,4);
        $this->crd->min_y = round($this->crd->min_y,4);
        $this->crd->max_y = round($this->crd->max_y,4);


        $fields[] = STR_LOGIN;
        $fields[] = STR_IMG;
        $fields[] = STR_IMG_ICON;
        $fields[] = STR_RATING;
        $f1 = '';
        $fltr = "";
        if ($G->user_id){
            $fltr = "(user_id=".$G->user_id." AND remove=0) OR ";
        }
        $fltr .= "(    (coord_x BETWEEN ".$this->crd->min_x." AND ".$this->crd->max_x.')';
        $fltr .= "AND (coord_y BETWEEN ".$this->crd->min_y." AND ".$this->crd->max_y.')';
        if($this->searchQuery)$fltr .= ' AND '.$this->searchQuery;
        foreach($this->cllct as $key=>$item){
            if($key != 'search_phrase')
                if(($item !== '') && ($item !== 'null') && ($item !== 'NULL') && ($item !== null))$f1 .= " AND ".$key." = '".$item."' ";
        }
        $fltr.= ")";
        if($f1 != '')$fltr.= ' '.$f1.') ORDER BY create_time LIMIT '.MAX_ADS_QT;

        $query = "SELECT * FROM ads WHERE (";

        $query .= $fltr;

//        mRESP_DATA($query);

        $res = $A_db->AGetMultiplyDataFromDb($query);
        $data = array();
        $str = "";
        if($res){
            foreach($res as $item1){
                $visibleMode = $this->filterTimeRange($item1);
                if (!$visibleMode)continue;
                $str .= '_'.$item1[STR_USER_ID];
                $user1 = new \structsPhp\StructUser();
                $user_id = $item1[STR_USER_ID];
                userFillData($user_id, $user1, $fields);

                $adFull = new \structsPhp\StructAds();
                arrayToArrayNotNull($item1,$adFull);
                if ($adFull->active == 0)$visibleMode = ADS_VISIBLE_HIDDEN_MANUAL;
                if ($adFull->remove == 1)$visibleMode = ADS_VISIBLE_HIDDEN_REMOVE;
                $adFull->user_id = $user_id                     ;
                $adFull->user_login = $user1->login             ;
                $adFull->user_rating = $user1->rating           ;
                $adFull->user_img = $user1->img                 ;
                $adFull->user_img_icon = $user1->img_icon       ;
                $adFull->visible_mode = $visibleMode;
                $data[] = $adFull;
                $user = null;
                $adFull = null;
            }
        }else{
            mRESP_DATA(0,0);
        }
        $G->adsCollection = $data;
        mRESP_DATA($str, count($data));
    }
    function getSelfAds(){
        global $A_db, $G;
        $user_id = $G->user_id;
        $query = "SELECT * FROM ads WHERE user_id=$user_id";
        $res = $A_db->AGetMultiplyDataFromDb($query);
        $data = array();
        if ($res){
            foreach ($res as $ads){
                $adFull = new \structsPhp\StructAds();
                arrayToArray($ads,$adFull);
                $adFull->user_id = $user_id                       ;
                $adFull->user_login = $G->user->login             ;
                $adFull->user_rating = $G->user->rating           ;
                $adFull->user_img = $G->user->img                 ;
                $adFull->user_img_icon = $G->user->img_icon       ;
                $data[] = $adFull;
                $adFull = null;
            }
            return $data;
        }
        return 0;
    }
    function getLifeTime( ){
        global $P;
        $tmp = $P->AGet(STR_LIFETIME);
        if($tmp){
            if(($tmp > 0)&&($tmp < 2592000)){
                return $tmp;
            }
        }
        return 2592000;
    }
    function removeAds(){
        global $P,$G, $A_db;
        $user_id = $P->AGet(STR_USER_ID);
        $ads_id = $P->AGet(STR_ID);
        if(($user_id == $G->user->id)&& $ads_id){
            $query = "SELECT user_id FROM ads WHERE id='$ads_id'";
            $res = $A_db->AGetSingleStringFromDb($query);
            if($res){
                if($res[STR_USER_ID]==$user_id){
                    $query="UPDATE ads SET remove='1' WHERE id='$ads_id'";
                    $res = $A_db->AQueryToDB($query);
                    if($res)mRESP_DATA(1);
                }
            }
        }
        mRESP_WTF();
    }
    function checkPostData($type){
        switch ($type){
            case STR_GET_ADS   :{
                $this->checkCollectionParameters();
                $this->checkMinMaxCoords();
                break;}
            case STR_ADD_ADS   :{
                $this->checkAddAdsData();
            }
        }
    }
    function checkMinMaxCoords(){
        global $P;
        $crdErr = 0;
        if(is_array($P->AGet('crd'))){
            arrayToArray($P->AGet('crd'), $this->crd);
            if($this->crd->min_x && $this->crd->max_x && $this->crd->min_y && $this->crd){
                if(!is_numeric($this->crd->min_x ))$crdErr = -1;
                if(!is_numeric($this->crd->max_x ))$crdErr = -1;
                if(!is_numeric($this->crd->min_y ))$crdErr = -1;
                if(!is_numeric($this->crd->max_y ))$crdErr = -1;
            }else $crdErr = -1;
        }else $crdErr = -1;
        if($crdErr){
            $this->crd->min_x = 55.6950;
            $this->crd->max_x = 55.8112;
            $this->crd->min_y = 37.4209;
            $this->crd->max_y = 37.8240;
        }
    }
    function checkAddAdsData(){
        if(!$this->adDb->ads_type || !$this->adDb->category || !$this->adDb->description ||
            !$this->adDb->coord_x || !$this->adDb->coord_y)mRESP_WTF();

        if((!(is_float($this->adDb->coord_x)) || !(is_float($this->adDb->coord_y))) &&
            (!(is_int($this->adDb->coord_x)  ) || !(is_int($this->adDb->coord_x)) ))mRESP_WTF();
    }
    function filterTimeRange($data){
        global $G;

        if (($data[STR_HOUR_START] == 0)&&($data[STR_HOUR_STOP] == 0)&&($data[STR_MIN_START] == 0)&&($data[STR_MIN_STOP] == 0))return ADS_VISIBLE_NORMAL;
        $date = getdate();
        $hour = $date[STR_HOURS];
        $min  = $date[STR_MINUTES];
        if($data[STR_HOUR_START] == $data[STR_HOUR_STOP]){
            if($hour == $data[STR_HOUR_START]){
                if($data[STR_MIN_START] ==  $data[STR_MIN_STOP])return ADS_VISIBLE_NORMAL;

                if($data[STR_MIN_START] <  $data[STR_MIN_STOP]){
                    if (($min >= $data[STR_MIN_START])&&($min <= $data[STR_MIN_STOP]))return ADS_VISIBLE_NORMAL;
                }else{
                    if (($min >= $data[STR_MIN_START]) || ($min <= $data[STR_MIN_STOP]))return ADS_VISIBLE_NORMAL;
                }
            }
        }else{
            if ($hour == $data[STR_HOUR_START]){
                if ($min >= $data[STR_MIN_START])return ADS_VISIBLE_NORMAL;
            }
            if ($hour == $data[STR_HOUR_STOP]){
                if ($min < $data[STR_MIN_STOP]) return ADS_VISIBLE_NORMAL;
            }

            if($data[STR_HOUR_START] < $data[STR_HOUR_STOP]){
                if(($hour > $data[STR_HOUR_START])&&($hour < $data[STR_HOUR_STOP]))return ADS_VISIBLE_NORMAL;
            }

            if($data[STR_HOUR_START] > $data[STR_HOUR_STOP]){
                if (($hour > $data[STR_HOUR_START])||($hour < $data[STR_HOUR_STOP]))return ADS_VISIBLE_NORMAL;
            }
        }

        if ($data[STR_USER_ID] == $G->user_id)return ADS_VISIBLE_HIDDEN_FOR_TIME;
        return ADS_VISIBLE_HIDDEN;
    }

    function hiddenAds(){
        global $P,$G, $A_db;
        $user_id = $P->AGet(STR_USER_ID);
        $ads_id = $P->AGet(STR_ID);
        if(($user_id == $G->user->id)&& $ads_id){
            $query = "SELECT user_id FROM ads WHERE id='$ads_id'";
            $res = $A_db->AGetSingleStringFromDb($query);
            if($res){
                if($res[STR_USER_ID]==$user_id){
                    $query="UPDATE ads SET active='0' WHERE id='$ads_id'";
                    $res = $A_db->AQueryToDB($query);
                    if($res)mRESP_DATA(1);
                }
            }
        }
        mRESP_WTF();
    }
    function showAds(){
        global $P,$G, $A_db;
        $user_id = $P->AGet(STR_USER_ID);
        $ads_id = $P->AGet(STR_ID);
        if(($user_id == $G->user->id)&& $ads_id){
            $query = "SELECT user_id, lifetime FROM ads WHERE id='$ads_id'";
            $res = $A_db->AGetSingleStringFromDb($query);
            if($res){
                if($res[STR_USER_ID]==$user_id){
                    $create_date = $G->date;
                    $create_time = $G->time;
                    $lifetime = $res[STR_LIFETIME];

                    $query="UPDATE ads SET active='1', create_date='$create_date', create_time='$create_time', lifetime='$lifetime'  WHERE id='$ads_id'";
                    $res = $A_db->AQueryToDB($query);
                    if($res)mRESP_DATA(1);
                }
            }
        }
        mRESP_WTF();
    }
    function recoveryAds()
    {
        global $P, $G, $A_db;




        $user_id = $P->AGet(STR_USER_ID);
        $ads_id = $P->AGet(STR_ID);
        if (($user_id == $G->user_id) && $ads_id) {
            $G->ads_id = $ads_id;
            $this->getTargetAds();
            if (!$G->targetAds->user_id            )mRESP_WTF();
            if ( $G->targetAds->user_id != $user_id)mRESP_WTF();

            $createTime = $G->time;
            $lifetime = $this->getLifeTime();
            $createDate = $G->date;
            $remoteAddr = $_SERVER[STR_REMOTE_ADDR];
            $query = "UPDATE ads SET  remove      ='0',
                                      active      ='1',
                                      create_date ='$createDate',
                                      create_time ='$createTime',
                                      lifetime    ='$lifetime', 
                                      remote_addr ='$remoteAddr'
                     WHERE id='$ads_id'";

            $res = $A_db->AQueryToDB($query);
            if ($res) mRESP_DATA(1);
            else    mRESP_WTF();
        }
        mRESP_WTF();
    }

    function generateTmpAds(){
        mRESP_DATA('OK');
    }
}









