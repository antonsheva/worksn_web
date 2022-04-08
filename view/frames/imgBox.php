<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class imgBox{
    var $id;
    function __construct($src){
        global $G;
        if (!file_exists($src))$src = '../../../service_img/design/gallery.gif';
        ?>
            <div id="imgBox" style="position: relative; width: 100%">
                <img class="img" alt="avatar" src="/<?echo $src?>" style="width: 100%; height: auto; border-radius: 5px">
            </div>
        <?
    }
}


