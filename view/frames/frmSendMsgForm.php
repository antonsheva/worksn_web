<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}


class frmSendMsgForm{
    public function __construct($id = 'frmSendMsgForm')
    {
        global $G;
        $placeholder = $G->user->id ? 'Введите текст сообщения' : 'Войдите в аккаунт, чтобы написать сообщение';
        $state = !$G->user->id ? 'disabled="disabled"' : '';?>
        <div id="frmSendMsgForm">
            <div class="printMsgProcessFrame">Печатает</div>
            <div style="width: 100%; display: block; position: relative; height: 100%">
                <img class="gallerySign" src="../../../service_img/design/gallery.gif"/>
                <input class="content" type="text" placeholder="<?echo $placeholder?>"   <?echo $state?>>
                <img class="btSend" src="../../../service_img/design/send_button.gif">
            </div>
        </div>
      <?

        $sel_arr[] = 'gallerySign';
        $sel_arr[] = 'btSend';
        new \jsFuncClick($id, $sel_arr, 'sendMsg');
    }
}