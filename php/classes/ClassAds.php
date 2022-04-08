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
        $this->AInitType();
        getPostData($this->adDb);
        getPostData($this->adFull);
        $this->checkPostData('get_ads');
        $this->getTargetAds();

    }
    function getSearchQuery(){
        global $P, $G;
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
        $ads_id = $P->AGet('ads_id');
        if(!$ads_id)$ads_id = $G->ads_id;
        if($ads_id)$A_db->ALoadStructFromDb('ads', $ads_id, $G->targetAds);
        if($G->targetAds->user_id)$G->owner_id = $G->targetAds->user_id;
        $G->targetAds->user_login = $G->owner->login;
        $G->targetAds->user_rating = $G->owner->rating;
    }
    function AInitType(){
        global $S, $G;
//        if($S->AGet('ads_type')){
//            $G->ads_type = $S->AGet('ads_type');
//        }else{
//            $G->ads_type = ADS_TYPE_WORKER;
//            $S->ASet('ads_type', ADS_TYPE_WORKER);
//        }
    }
    function ASetAdsType($type){
        global $S, $G;
        if($type){
            $G->ads_type = $type;
            $S->ASet('ads_type', $type);
        }
    }
    function AAddAds(){
        global $P,$G, $A_db, $S, $AC_img;

        $lifetime = $this->getLifeTime();
        $user_id = $P->AGet('user_id');
        if($user_id == $G->user->id){

            if($P->AGet('edit')){
               $G->ads_id = $P->AGet('id');
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
            $this->adDb->remote_addr = $_SERVER['REMOTE_ADDR'];
            $this->adDb->id = $A_db->ASaveDataToDb($this->adDb,'ads', $this->adDb->id)['id'];
            if($this->adDb->id){
                $this->adFull->user_login = $G->user->login;
                $this->adFull->user_img   = $G->user->img;
                arrayToArrayNotNull($this->adDb, $this->adFull);
                $G->targetAds = $this->adFull;
                $AC_img->removeOldImgsFromSession();
                mRESP_DATA("Объявление успешно добавлено");

                $_SERVER['REMOTE_ADDR'];
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
        if ($P->AGet('edit'))$this->removeOldImgs();
        try{
            $arr = explode(',', $this->adDb->img);
        }catch (\Exception $e){
            mRESP_WTF('error save images');
            $arr = null;
        }
        if(is_array($arr)){
            $this->adDb->img = '';
            foreach ($arr as $item){
                if($item && ($item !='')){
                    $imgPath = $AC_img->saveImg($DIR->tmp_img.$item,$DIR->ads_imgs);
                    $this->adDb->img     .= $imgPath['img'].',';
                    $this->adDb->img_icon.= $imgPath['imgIcon'].',';
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
        if ($P->AGet('old_imgs')){
            $fileList = $P->AGet('old_imgs');
            $res = $AC_img->removeFileList($fileList, 0);
            $errCnt += $res['errCnt'];
            $errFiles.= $res['errFiles'];
        }
        if ($P->AGet('old_imgs')){
            $fileList = $P->AGet('old_imgs_icon');
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
        $adsId   = $P->AGet('ads_id');
        $img     = $P->AGet('img');
        $imgIcon = $P->AGet('img_icon');
        if (!$G->targetAds->user_id)mRESP_WTF('ads data error');
        if ($G->targetAds->user_id != $G->user_id)mRESP_WTF('adsId -> '.$G->targetAds->id.' user data error');
        if ($img){
            $res = $AC_img->copyImgsToTmpFolder($img, $imgIcon);
            $G->img_list = $res['img_list'];
            mRESP_DATA(0, $res['img_cnt']);
        }
        mRESP_DATA(0);
    }
    function updateAds(){
        global $P,$G, $A_db;
        $user_id = $P->AGet('user_id');
        $ads_id  = $P->AGet('ads_id');
        $lifetime = $this->getLifeTime();
        if(($user_id === $G->user->id) && $ads_id && ($user_id === $this->adDb->user_id)){
            $this->adDb->img = $G->user->img;
            $this->adDb->create_date = $G->date;
            $this->adDb->create_time = $G->time;
            $this->adDb->lifetime = $lifetime;
            $this->adDb->remove = 0;
            $this->adDb->id = $A_db->ASaveDataToDb($this->adDb,'ads', $ads_id)['id'];
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
        if(is_array($P->AGet('cllct'))){
            arrayToArray($P->AGet('cllct'), $this->cllct);
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


        $fields[] = 'login';
        $fields[] = 'img';
        $fields[] = 'img_icon';
        $fields[] = 'rating';
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
        if($f1 != '')$fltr.= ' '.$f1.') ORDER BY create_time LIMIT 200';

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
                $str .= '_'.$item1['user_id'];
                $user1 = new \structsPhp\StructUser();
                $user_id = $item1['user_id'];
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
            mRESP_DATA("no ads", 0);
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
        $tmp = $P->AGet('lifetime');
        if($tmp){
            if(($tmp > 0)&&($tmp < 2592000)){
                return $tmp;
            }
        }
        return 2592000;
    }
    function removeAds(){
        global $P,$G, $A_db;
        $user_id = $P->AGet('user_id');
        $ads_id = $P->AGet('id');
        if(($user_id == $G->user->id)&& $ads_id){
            $query = "SELECT user_id FROM ads WHERE id='$ads_id'";
            $res = $A_db->AGetSingleStringFromDb($query);
            if($res){
                if($res['user_id']==$user_id){
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
            case 'get_ads'   :{
                $this->checkCollectionParameters();
                $this->checkMinMaxCoords();
                break;}
            case 'add_ads'   :{
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

        if (($data['hour_start'] == 0)&&($data['hour_stop'] == 0)&&($data['min_start'] == 0)&&($data['min_stop'] == 0))return ADS_VISIBLE_NORMAL;
        $date = getdate();
        $hour = $date['hours'];
        $min  = $date['minutes'];
        if($data['hour_start'] == $data['hour_stop']){
            if($hour == $data['hour_start']){
                if($data['min_start'] ==  $data['min_stop'])return ADS_VISIBLE_NORMAL;

                if($data['min_start'] <  $data['min_stop']){
                    if (($min >= $data['min_start'])&&($min <= $data['min_stop']))return ADS_VISIBLE_NORMAL;
                }else{
                    if (($min >= $data['min_start']) || ($min <= $data['min_stop']))return ADS_VISIBLE_NORMAL;
                }
            }
        }else{
            if ($hour == $data['hour_start']){
                if ($min >= $data['min_start'])return ADS_VISIBLE_NORMAL;
            }
            if ($hour == $data['hour_stop']){
                if ($min < $data['min_stop']) return ADS_VISIBLE_NORMAL;
            }

            if($data['hour_start'] < $data['hour_stop']){
                if(($hour > $data['hour_start'])&&($hour < $data['hour_stop']))return ADS_VISIBLE_NORMAL;
            }

            if($data['hour_start'] > $data['hour_stop']){
                if (($hour > $data['hour_start'])||($hour < $data['hour_stop']))return ADS_VISIBLE_NORMAL;
            }
        }

        if ($data['user_id'] == $G->user_id)return ADS_VISIBLE_HIDDEN_FOR_TIME;
        return ADS_VISIBLE_HIDDEN;
    }

    function hiddenAds(){
        global $P,$G, $A_db;
        $user_id = $P->AGet('user_id');
        $ads_id = $P->AGet('id');
        if(($user_id == $G->user->id)&& $ads_id){
            $query = "SELECT user_id FROM ads WHERE id='$ads_id'";
            $res = $A_db->AGetSingleStringFromDb($query);
            if($res){
                if($res['user_id']==$user_id){
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
        $user_id = $P->AGet('user_id');
        $ads_id = $P->AGet('id');
        if(($user_id == $G->user->id)&& $ads_id){
            $query = "SELECT user_id, lifetime FROM ads WHERE id='$ads_id'";
            $res = $A_db->AGetSingleStringFromDb($query);
            if($res){
                if($res['user_id']==$user_id){
                    $create_date = $G->date;
                    $create_time = $G->time;
                    $lifetime = $res['lifetime'];

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




        $user_id = $P->AGet('user_id');
        $ads_id = $P->AGet('id');
        if (($user_id == $G->user_id) && $ads_id) {
            $G->ads_id = $ads_id;
            $this->getTargetAds();
            if (!$G->targetAds->user_id            )mRESP_WTF();
            if ( $G->targetAds->user_id != $user_id)mRESP_WTF();

            $createTime = $G->time;
            $lifetime = $this->getLifeTime();
            $createDate = $G->date;
            $remoteAddr = $_SERVER['REMOTE_ADDR'];
            $query = "UPDATE ads SET  remove      ='0',
                                      active      ='1',
                                      create_date ='$createDate',
                                      create_time ='$createTime',
                                      lifetime    ='$lifetime', 
                                      remote_addr ='$remoteAddr'
                     WHERE id='$ads_id'";

            $res = $A_db->AQueryToDB($query);
            if ($res) mRESP_DATA(1);
            else    mRESP_WTF('error query to DB');
        }
        mRESP_WTF('error post data');
    }




    function generateTmpAds(){
        global $A_db, $G;

        if ($G->user_id != 1)mRESP_DATA('uWTF');

        define("MIN_X", 41);
        define("MAX_X", 69);
        define("MIN_Y", 23);
        define("MAX_Y", 141);

        $cnt = 0;
        $imgs     = array('wksn_users_img/ads_imgs/f1_71/f2_58/701a52e7c2cc6dfb1c54_1218871972827623_1646669400.jpg',
            ' ',
            ' ',
            'wksn_users_img/ads_imgs/f1_03/f2_27/PC_1219360736676350_1646669889.jpg',
            'wksn_users_img/ads_imgs/f1_72/f2_30/c213c60ac9687ff342d6_1219874453265264_1646670403.jpeg',
            'wksn_users_img/ads_imgs/f1_61/f2_45/scale_1200_1220162049604247_1646670690.jpg',
            ' ',
            'wksn_users_img/ads_imgs/f1_09/f2_39/kompqjytery-dell-302_1220542885581440_1646671071.jpg');
        $imgsIcon = array('wksn_users_img/ads_imgs_icon/f1_71/f2_58/701a52e7c2cc6dfb1c54_1218871972827623_1646669400.jpg',
            ' ',
            ' ',
            'wksn_users_img/ads_imgs_icon/f1_03/f2_27/PC_1219360736676350_1646669889.jpg',
            'wksn_users_img/ads_imgs_icon/f1_72/f2_30/c213c60ac9687ff342d6_1219874453265264_1646670403.jpeg',
            'wksn_users_img/ads_imgs_icon/f1_61/f2_45/scale_1200_1220162049604247_1646670690.jpg',
            ' ',
            'wksn_users_img/ads_imgs_icon/f1_09/f2_39/kompqjytery-dell-302_1220542885581440_1646671071.jpg');


        $t = new TxtData();
        $extAdsEmployer = $t->extAdsEmployer;
        $extAdsWorker   = $t->extAdsWorker;
        $description = array('Некому сходить в магазин? '.$extAdsEmployer,
            'Некому послать посылку? '.$extAdsEmployer,
            'Нужен помощник? '.$extAdsEmployer,
            'Не работает компьютер? Найдите специалиста или оставьте объявление. '.$extAdsEmployer,
            'Сломалась стиральная машина? Найдите специалиста или оставьте объявление. '.$extAdsEmployer,
            'Есть свободные 15 минут? Проживите их с пользой - помогите другим. '.$extAdsWorker,
            'Есть свободные 15 минут? Проживите их с пользой - помогите другим. '.$extAdsWorker,
            'Можете: разобраться с компьютером, установить Windows, настроить WiFi...? Помогите другим. '.$extAdsWorker);

        $category = array(1,2,3,4,5,1,3,4);
        $type     = array(2,2,2,2,2,1,1,1);
        $cost     = array(100,200,500,1000,1000,100,500,500);
        $userId   = array(279,279,279,279,279,278,278,278);
        $adsCnt = 0;
        for ($x = MIN_X; $x < MAX_X; $x+=0.5){
            for ($y = MIN_Y; $y < MAX_Y; $y+=1){
                $ads = new \structsPhp\dbStruct\tblAds();
                $ads->user_id     = $userId[$cnt];
                $ads->img         = $imgs[$cnt];
                $ads->img_icon    = $imgsIcon[$cnt];
                $ads->description = $description[$cnt];
                $ads->cost        = $cost[$cnt];
                $ads->category    = $category[$cnt];
                $ads->ads_type    = $type[$cnt];
                $ads->coord_x     = $x;
                $ads->coord_y     = $y;

                $ads->create_date = $G->date;
                $ads->create_time = $G->time;
                $ads->lifetime    = 2592000;
                $ads->remove      = 0;
                $ads->remote_addr = $_SERVER['REMOTE_ADDR'];

                $A_db->ASaveDataToDb($ads,'ads');
                $cnt++;
                if ($cnt>7)$cnt = 0;
                $adsCnt++;
            }
        }
        mRESP_DATA('adsCnt -> '.$adsCnt);
    }
}









