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
            <img class="roll" src="<?echo URL_IMG_DOWN_AZURE?>">
            <img class="expand" src="<?echo URL_IMG_BT_OPEN_EXPAND?>">
            <div class="profile">
                <a class="href" href="/">
                    <img class="avatar" src="<?echo URL_IMG_NO_AVATAR?>"/>
                    <img class="online" src="<?echo URL_IMG_ONLINE?>"/>
                </a>
                <div class="stars">
                    <img class="smallStars" style="height: 20px" src="<?echo URL_IMG_STARS_BAD_BGRD?>">
                    <img class="slider" style="height: 20px; width:20%" src="<?echo URL_IMG_STARS_OK_BGRD?>" >
                    <img class="smallStars" style="height: 20px" src="<?echo URL_IMG_STARS?>">
                </div>
            </div>
            <div class="adsData">
                <div class="str1">
                    <div class="login" style="">login</div>
                    <div class="time">--:--</div>
                </div>

                <div class="str2">
                    <div class="loadImgs">
                        <img src="<?echo URL_IMG_BELL_ACT?>">
                    </div>
                    <div style="width: 50%; display: inline-block; vertical-align: top">
                        <div class="category"><?echo STRING_CATEGORY?></div>
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










