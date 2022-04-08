<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}



class frmReplyToMsgForm{
    function __construct()
    {
        $id = 'replyToMsgForm';
        ?>
        <div id="replyToMsgForm" class="replyToMsgForm">
            <img class="close" src="/service_img/design/remove.gif">
            <a class="login">login</a>
            <img class="img" src="">
            <div class="content">
                <div class="a1">
                    <a>мой Тузик тоже иногда гавкает на улице, но почему-то МИД не делает замечаний в его адрес и СМИ тоже не освещают это событие. Даже на Украине говорят: комментировать бред этого сумасшедшего - себя не уважать.</a>
                </div>
            </div>
        </div>
    <?
        $sel[] = 'close';
        new \jsFuncClick($id, $sel, 'replyToMsgForm');
    }

}