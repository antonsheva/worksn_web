<?php
if($A_start != 444){echo 'byby';exit();}

global $ROOT, $G, $DIR;
$img = $DIR->noAvatar;
if($G->user->img)
    if (file_exists($G->user->img))$img = $G->user->img_icon;

include $ROOT.'/www/view/forms/sendAvatar.php';
new \framesView\frmMyProfileSign($G->user_id);
?>

<div class="layoutRegistration">
    <table style="width: 100%;">
        <tr>
            <td>
                <div  class="userAvatar" style="width: 200px; display: block; margin: auto">
                    <?new \framesView\imgBox($img );?>
                </div>
            </td>
        </tr>
        <tr>
            <td class="roundSendForm">
                <?
                if($G->user->auto_auth)new \framesView\updtAutoAuthData();
                else                   new \framesView\updtUserData();
                ?>
            </td>
        </tr>
        <?if(!$G->user->auto_auth){?>
        <tr>
            <td class="roundSendForm">
                <?{new \framesView\chngPass();}?>
            </td>
        <?}?>
        </tr>
    </table>
</div>
 



