<?php
if($A_start != 444){echo 'byby';exit();}

global $G, $DIR;
$img = URL_IMG_NO_AVATAR;
if($G->user->img)
    if (file_exists($G->user->img))$img = $G->user->img_icon;

new \framesView\frmSendAvatar();
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
 



