<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class frmLoginForm{
    function __construct($id = 'loginForm'){
        $mDetect = new \Mobile_Detect() ;
        $isAndroid = $mDetect->isAndroidOS();
        $width = $isAndroid ? "28%" : "37%";
        $paddingRight = $isAndroid ? 1 : 4;
        ?>
        <div id="loginForm">
            <table style="width: 100%; height: 40%; margin-top: 2%; position: relative; padding-right: <?echo $paddingRight?>%">
                <tr style="width: 100%; height: 100%; display: block">
                    <td class="txt" style="width: <?echo $width?>; height: 100%;">
                        <input class="login" type="text" placeholder="<?echo STRING_LOGIN?>" style="width: 100%;  font-size: larger;">
                    </td>
                    <td class="txt" style="width: <?echo $width?>; height: 100%;">
                        <input class="password" type="password" placeholder="<?echo STRING_PASSWORD?>" style="width: 100%; font-size: larger;">
                    </td>
                    <td style="height: 100%; width: 22.5%; text-align: center">
                        <input class="bt" type="button" value="<?echo STRING_SIGN_IN?>" style="width: 90%; font-size: larger;">
                    </td>
                    <?if ($isAndroid)new frmSignGooglePlay();?>

                </tr>
            </table>

            <div style="width: 80%; height: 1px; background-color: #9d9f9d; margin-left: 10%; "></div>
            <table class="tblRegForm" style="width: 100%; height: 50%; padding-top: 2%">
                <tr>
                    <td style="width: 25%">
                        <div style="width: 100%; text-align: center">
                            <a class="registration" href="/registration" ><h3><?echo STRING_REGISTRATION?></h3></a>
                        </div>
                    </td>
                    <td style="width: 48%">
                        <div style="width: 100%; text-align: center">
                            <a class="registration" href="/recovery"  ><h3><?echo STRING_RECOVER_PASSWORD?></h3></a>
                        </div>
                    </td>
                    <td style="width: 25%">
                        <div style="width: 100%; text-align: center">
                            <a class="anonym"><h3><?echo STRING_ANONYMOUS?></h3></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <?
        $sel_arr[] = 'bt';
        $sel_arr[] = 'anonym';
        new \jsFuncClick($id, $sel_arr, 'loginForm');
    }
}

?>
