<?php
if($A_start != 444){echo 'byby';exit();}

global $G;
$img = "../../../service_img/avatars/no-avatar.jpg";?>
<div class="tmpImgBox">
    <?  $img = "../../../service_img/design/gallery.gif";
    new \framesView\imgBox($img );
    new \framesView\frmSendImageMsg();
    ?>
</div>
<div id="userProfile">
    <table style="width: 90%;position: relative; margin: auto; height: 40%">
        <tr>
            <td rowspan="6" style="width: 110px">
                <?new \framesView\uCardSmall($G->owner, 1, 100,10)?>
            </td>
        </tr>
        <tr>
            <td style="visibility: hidden"></td>
        </tr>
        <tr>
            <td class="name_sname">
                <a class="name" style="display: inline-block"></a><a>&nbsp;&nbsp;</a><a class="s_name" style="display: inline-block"></a>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <a>в сети с: </a><a class="create_date">create_date</a>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <a class="last_time"></a>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <a>голосов: </a><a class="vote_qt"></a>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="visibility: hidden">
                1234567
            </td>
        </tr>
        <tr>
            <td colspan="3" class="q1">
                <img class="ban"      src="<?echo URL_IMG_NO_BAN?>">
                <img class="like"     src="<?echo URL_IMG_NO_CHOOSE?>">
                <img class="messages" src="<?echo URL_IMG_ENVELOPE?>">
            </td>
        </tr>

        <tr>
            <td colspan="3" style="margin-top: 20px">
                <div class="padd_5"><textarea class="txt_review" placeholder="Тут Вы можете добавить отзыв о данном пользователе"></textarea></div>
                <input class="bt stlBtSmall" style="width: 100%"      type="button" value="Оставить отзыв">
            </td>
        </tr>

    </table>
    <table  style="width: 90%; position: relative; margin: auto; height: 10%">
        <tr>
            <td style="width: 20%; text-align: center">
                <div class="star" data-star_numb="1"><img src="/service_img/design/star_empty.gif"></div>
            </td>
            <td style="width: 20%; text-align: center">
                <div class="star" data-star_numb="2"><img src="/service_img/design/star_empty.gif"></div>
            </td>
            <td style="width: 20%; text-align: center">
                <div class="star" data-star_numb="3"><img src="/service_img/design/star_empty.gif"></div>
            </td>
            <td style="width: 20%; text-align: center">
                <div class="star" data-star_numb="4"><img src="/service_img/design/star_empty.gif"></div>
            </td>
            <td style="width: 20%; text-align: center">
                <div class="star" data-star_numb="5"><img src="/service_img/design/star_empty.gif"></div>
            </td>
        </tr>
    </table>
    <div id="userReviewsField"></div>
    <?

    $sel_arr[] = 'bt';
    $sel_arr[] = 'star';
    $sel_arr[] = 'ban';
    $sel_arr[] = 'like';
    $sel_arr[] = 'messages';
    new jsFuncClick('userProfile', $sel_arr, 'userProfile');
    ?>
</div>