<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 28.01.2021
 * Time: 7:00
 */

namespace framesView;


use structsPhp\Dir;
use structsPhp\G;
use structsPhp\StructUser;

class frmDiscusCard{
    public function __construct($id = 'frmDiscusCard'){
        global $G;
        $user = $G->owner->id ? $G->owner : null;
        ?>
        <div id="frmDiscusCard">
            <img class="roll" src="../../../service_img/design/sn_down_azure.gif">
            <img class="expand" src="../../../service_img/design/bt_open_expand.png">
            <div class="profile">
                <a class="href" href="/">
                    <img class="avatar" src="../../../service_img/avatars/no-avatar.jpg"/>
                    <img class="online" src="../../../service_img/design/online.gif"/>
                </a>
                <div class="stars">
                    <img class="smallStars" style="height: 20px" src="../../../service_img/design/stars_bad_bgrd.gif">
                    <img class="slider" style="height: 20px; width:20%" src="../../../service_img/design/stars_ok_bgrd.gif" >
                    <img class="smallStars" style="height: 20px" src="../../../service_img/design/stars.gif">
                </div>
            </div>
            <div class="adsData">
                <div class="str1">
                    <div class="login" style="">login</div>
                    <div class="time">--:--</div>
                </div>

                <div class="str2">
                    <div class="loadImgs">
                        <img src="../../../service_img/design/bell_act.png">
                    </div>
                    <div style="width: 50%; display: inline-block; vertical-align: top">
                        <div class="category">category</div>
                        <div class="cost">100p.</div>
                    </div>
                </div>
            </div>


        </div>
        <?

        $sel[] = 'adsData';
        $sel[] = 'loadImgs';
        $sel[] = 'roll';
        $sel[] = 'expand';
        new \jsFuncClick($id, $sel, 'frmDiscusCard');
    }
}










