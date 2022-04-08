<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class frmSendImageMsg{
    public function __construct($id = 'sendImgMsg')
    {?>
        <div id="sendImgMsg">
            <input class="content" type="text" placeholder="Текст сообщения">
            <img class="bt" src="../../../service_img/design/send_button.gif" />
        </div>
        <?$sel_arr[] = 'bt';
        new \jsFuncClick($id, $sel_arr, 'sendImgMsg');
    }
}
