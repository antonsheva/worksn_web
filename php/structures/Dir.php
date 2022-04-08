<?php
namespace structsPhp;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class Dir{
    var $tmp_img       = 'wksn_users_img/tmp_img/';
    var $tmp_img_icon  = 'wksn_users_img/tmp_img/icon/';
    var $avatars       = 'wksn_users_img/avatars';
    var $msg_imgs      = 'wksn_users_img/msg_imgs';
    var $ads_imgs      = 'wksn_users_img/ads_imgs';
    var $design        = 'service_img/design/';
    var $noAvatar      = 'service_img/avatars/no-avatar.jpg';
}