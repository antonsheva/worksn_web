<?php
if($A_start != 444){echo 'byby';exit();}

global $ROOT, $G;
$img = "service_img/avatars/no-avatar.jpg";
include $ROOT.'/www/view/forms/sendAvatar.php';
include (__DIR__."/../html/linkPlayMarket.html");
?>
<div class="layoutRegistration">
    <table style="width: 100%;">
        <tr>
            <td>
                <div  class="userAvatar" style="width: 100px; display: block; margin: auto">
                    <?new \framesView\imgBox($img);?>
                </div>
            </td>
        </tr>
        <tr>
            <td class="roundSendForm"><?
                new \framesView\regForm();?>
            </td>
        </tr>
    </table>
    <br>
    <div id="settingPageContent" style="position: relative; left: 30px"></div><br>
</div>





