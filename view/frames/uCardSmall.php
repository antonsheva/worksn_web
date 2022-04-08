<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 28.01.2021
 * Time: 7:03
 */

namespace framesView;


use structsPhp\G;
use structsPhp\StructUser;
use structsPhp\StructUserShort;

class uCardSmall{
    public function __construct(StructUserShort $user=null, $showRating = 0, $height=80, $radius = 3)
    {
        global $G;
        $user_id = $user ? $user->id : 0;
        $img     = "/service_img/avatars/no-avatar.jpg";
        $imgIcon = "/service_img/avatars/no-avatar.jpg";
        if ($user){
            if($user->img_icon)
                $imgIcon = $user->img_icon;

            if ($user->img)
                $img = $user->img;
            else
                $img = $imgIcon;
        }


        $login = $user ? $user->login : 'login';
        $rating = $user ? $user->rating : 100;
        $href = $user_id == $G->user->id ?  '/../my_profile' :
                                            '/../user_profile/'.$user_id;

        $id = 'frmAvatar';
    ?>
        <div id="<?echo $id?>" class="href_user" >
            <div style="width: 100%; text-align: center">

                <div class="menu_login"><?echo $login?></div>
                <img class="online <?echo $user_id?>" src="/service_img/design/online.gif" >
                <object data="/<?echo $imgIcon?>" style="height: <?echo $height?>px; border-radius: <?echo $radius?>%" class="avatarImg">
                <img class="avatarImg" src="../../../service_img/avatars/no-avatar.jpg" style="height: <?echo $height?>px; border-radius: <?echo $radius?>%"><br>
                </object>
            </div>
            <?if($showRating)new ratingStars($rating, $height/5)?>
        </div>
    <?

        $sel[] = 'avatarImg';
        new \jsFuncClick($id, $sel, 'userProfile');
    }
}