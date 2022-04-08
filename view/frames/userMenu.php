<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}
class userMenu{
    function __construct(){
        global $G;
        $img = "../../../service_img/avatars/no-avatar.jpg";
        if($G->user->img_icon)$img = $G->user->img_icon;
        $sel_arr = array();
        $id = 'userMenu';
        $mDetect = new \Mobile_Detect() ;
        $isAndroid = $mDetect->isAndroidOS();
        ?>

        <table id="userMenu">
            <tr>
                <td class="profile q2">
                    <a href="/../my_profile">
                        <img src="../../../service_img/design/profile.png"/>
                    </a>
                </td>
                <td class="allMsg q2">
                    <img src="../../../service_img/design/konvert.png"/>
                </td>
                <td class="newMsg q2">
                    <img src="../../../service_img/design/no_bell.png"/>
                </td>
                <td class="like q2">
                    <img src="../../../service_img/design/no_choose.png"/>
                </td>
                <td class="ban q2">
                    <img src="../../../service_img/design/no_ban.png"/>
                </td>
                <td class="exit q2">
                    <img src="../../../service_img/design/exit.png"/>
                </td>
                <td class="setting q2">
                    <a href="/../setting">
                        <img src="../../../service_img/design/setting.png"/>
                    </a>
                </td>
                <?if ($isAndroid)include (__DIR__."/../html/linkPlayMarketSign.html");?>

            </tr>
        </table>

        <?
        $sel_arr[] = 'exit';
        $sel_arr[] = 'like';
        $sel_arr[] = 'ban';
        $sel_arr[] = 'allMsg';
        $sel_arr[] = 'newMsg';
        new \jsFuncClick($id, $sel_arr, 'userMenu');

    }
}



?>


