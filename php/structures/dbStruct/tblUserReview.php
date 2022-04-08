<?php
namespace structsPhp\dbStruct;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class tblUserReview{
    var $id             = null;
    var $sender_id      = null;
    var $consumer_id    = null;
    var $star_qt        = null;
    var $favorite       = null;
    var $comment        = null;
    var $create_date    = null;
    var $img            = null;
    var $img_icon       = null;

}