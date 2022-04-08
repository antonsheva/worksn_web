<?php
namespace structsPhp;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class StructUser
{
     var $id             = null;
     var $login          = null;
     var $password       = null;
     var $cookie_pass    = null;
     var $auto_auth      = null;
     var $name           = null;
     var $s_name         = null;
     var $phone          = null;
     var $email          = null;
     var $img            = null;
     var $img_icon       = null;
     var $city_id        = null;
     var $region_id      = null;
     var $create_date    = null;
     var $last_time      = null;
     var $rating         = null;
     var $rights         = null;
     var $vote_qt        = null;
     var $web_site       = null;
     var $about_user     = null;
     var $ws_token       = null;
     var $app_id         = null;
     var $email_hash     = null;
     var $confirm_email  = null;
     var $system_notify  = null;
     var $notify_id      = null;
     var $bw_status      = null;
     var $ban_list       = null;
     var $like_list      = null;
     var $choose_ads     = null;
     var $remote_addr    = null;

}