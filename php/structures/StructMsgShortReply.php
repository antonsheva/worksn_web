<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 13.07.2021
 * Time: 21:05
 */

namespace structsPhp;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class StructMsgShort
{
    var $id                 = null;
    var $sender_id          = null;
    var $consumer_id        = null;
    var $discus_id          = null;
    var $content            = null;
    var $img                = null;
    var $img_icon           = null;
    var $view               = null;
    var $create_date        = null;
    var $reply_msg_id       = null;
    var $reply_content      = null;
    var $reply_sender_id    = null;
    var $reply_sender_login = null;
    var $reply_img          = null;
}