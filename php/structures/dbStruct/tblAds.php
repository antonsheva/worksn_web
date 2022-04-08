<?php
namespace structsPhp\dbStruct;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class tblAds{
    var $id          = null;
    var $ads_type    = null;
    var $user_id     = null;
    var $category    = null;
    var $active      = null;
    var $coord_x     = null;
    var $coord_y     = null;
    var $img         = null;
    var $img_icon    = null;
    var $description = null;
    var $cost        = null;
    var $create_date = null;
    var $create_time = null;
    var $lifetime    = null;
    var $remove      = null;
    var $hour_start  = null;
    var $hour_stop   = null;
    var $min_start   = null;
    var $min_stop    = null;
    var $remote_addr = null;
}