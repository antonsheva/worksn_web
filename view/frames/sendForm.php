<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}


class sendForm{
    public function __construct($id = 'sendForm')
    {
        global $G;
        $placeholder = $G->user->id ? 'Введите текст сообщения' : 'Войдите в аккаунт';
        $state = !$G->user->id ? 'disabled="disabled"' : '';?>
        <div id="sendForm">
            <div class="printMsgProcessFrame">Печатает</div>
<!--            <div class="replyToMsgForm">-->
<!--                <img class="close" src="/service_img/design/remove.gif">-->
<!--                <a class="login">login</a>-->
<!--            </div>-->
            <table>
                <tr style="width: 100%">
                    <td>

                    </td>
                    <td>
                        <div  style="text-align: left; width: 100%"> <img class="gallerySign" src="../../../service_img/design/gallery.gif"></div>
                    </td>
                    <td style="width: 100%">
                        <input id="inputMsgContent" class="content" type="text" placeholder="<?echo $placeholder?>" style="width: 100%; font-size: larger" <?echo $state?>>
                    </td>
                    <td style="width: 30%">
                        <img class="btSend" src="/service_img/design/send_button.gif">
                    </td>
                </tr>
            </table>
        </div>
      <?$sel_arr[] = 'btSend';
        new \jsFuncClick($id, $sel_arr, 'sendMsg');
    }
}