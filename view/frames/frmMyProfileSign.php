<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}


class frmMyProfileSign{
    function __construct($id){?>
        <a class="homeSign" href="/user_profile/<?echo $id?>" style="top: 8%;">
            <img src="../../../service_img/design/profile.png">
        </a>
    <?}
}

