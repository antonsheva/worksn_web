<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}
class userMenu{
    function __construct(){
        $sel_arr = array();
        $id = 'userMenu';
        $mDetect = new \Mobile_Detect() ;
        $isAndroid = $mDetect->isAndroidOS();
        ?>

        <table id="userMenu">
            <tr>
                <td class="profile q2">
                    <a href="<?echo LINK_MY_PROFILE?>">
                        <img src="<?echo URL_SIGN_PROFILE?>"/>
                    </a>
                </td>
                <td class="allMsg q2">
                    <img src="<?echo URL_SIGN_ENVELOPE?>"/>
                </td>
                <td class="newMsg q2">
                    <img src="<?echo URL_SIGN_BELL_NO_ACT?>"/>
                </td>
                <td class="like q2">
                    <img src="<?echo URL_SIGN_NO_CHOOSE?>"/>
                </td>
                <td class="ban q2">
                    <img src="<?echo URL_SIGN_NO_BAN?>"/>
                </td>
                <td class="exit q2">
                    <img src="<?echo URL_SIGN_EXIT?>"/>
                </td>
                <td class="setting q2">
                    <a href="<?echo LINK_SETTING?>">
                        <img src="<?echo URL_SIGN_SETTING?>"/>
                    </a>
                </td>
                <?if ($isAndroid)include (LINK_G_PLAY);?>

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


