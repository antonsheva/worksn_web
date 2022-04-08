<?php
namespace structsPhp\dbStruct;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class tblNotify{
    var $id = null;
    var $user_id = null;
    var $create_date = null;
    var $content = null;
    var $img = null;
    var $img_icon = null;
    var $type = null;
    var $view = null;
}