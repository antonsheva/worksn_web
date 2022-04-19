<?php
namespace structsPhp;
global $A_start;

use structsPhp\dbStruct\tblDiscus;

if($A_start != 444){echo 'byby';exit();}

class G{
    var $act = null;
    var $user_id = null;
    var $owner_id = null;
    var $user;
    var $owner;
    var $speaker;
    var $selfReview;
    var $userReview;
    var $userReviews = null;
    var $location_page;
    var $mode = MODE_MAIN;
    var $obj_cnt = 0;
    var $tmp_img = null;
    var $tmp_img_icon = null;
    var $img_list = null;
    var $img_filename = null;
    var $msg_create_id = null;
    var $ads_type = null;
    var $ads_category = null;
    var $ads_owner_id = null;
    var $rtrn;
    var $date;
    var $dateFull;
    var $time;
    var $adsCollection = array();
    var $messages      = array();
    var $targetAds = null;
    var $targetMsg = null;
    var $page_param = array();
    var $discus;
    var $test_data = null;
    var $img_size = 800;
    var $nSecTime;
    var $catList;
    var $lifetimeList;
    var $ads_id = null;
    var $email_hash = null;
    var $haveSysNotify = 0;
    var $notifies = array();
    var $saveImgData = null;
    var $usersList = null;
    var $months  = array(1=>'янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек');
    function __construct(){
        $this->dateFull = date('Y-m-d H:i:s');
        $this->date     = date('d-'.$this->months[date( 'n' )].' H:i');
        $this->time = time();
        $this->nSecTime = hrtime(true);
        $this->discus = new tblDiscus();
        $this->user = new StructUser();
        $this->owner = new StructUserShort();
        $this->speaker = new StructUserShort();
        $this->targetAds = new StructAds();
        $this->rtrn = new StructReturn();
        $this->selfReview = new dbStruct\tblUserReview();
        $this->userReview = new dbStruct\tblUserReview();
//        $this->catList = array('Все категории','Сходить в магазин','Курьер','Помощь по дому','Компьютерная помощь','Ремонт быт. техники','Водитель','Куплю/Продам','Подарю/Приму в дар');
        $this->catList = array( 'cat -> 0',
                                'cat -> 1',
                                'cat -> 2',
                                'cat -> 3',
                                'cat -> 4',
                                'cat -> 5',
                                'cat -> 6',
                                'cat -> 7',
                                'cat -> 8',
                                );//'Переписка с администратором.'


        $this->lifetimeList  = array( 600      , 3600  , 28800   , 86400  , 604800 ,  2592000);
        $this->lifetimeNames = array('10 минут','1 час','8 часов','1 день','7 дней', '30 дней');
    }
}





