<?php
namespace structsPhp;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class StructUserShort
{
     var $id             = null;
     var $login          = null;
     var $name           = null;
     var $s_name         = null;
     var $img            = null;
     var $img_icon       = null;
     var $create_date    = null;
     var $last_time      = null;
     var $rating         = null;
     var $vote_qt        = null;
     var $about_user     = null;
     var $bw_status      = null;
}