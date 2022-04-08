<?php
    if($A_start != 444){echo 'byby';exit();}
    include (__DIR__."/../html/linkPlayMarket.html");
?>

<div class="settingBody">
    <div id="layoutSetting">
        <b class="notifyType">Уведомления</b>
        <div class="systemNotify">
            <a class="notify"></a>
        </div>
        <div class="underLine"></div>
        <div>
            <p><input class="checkShowStatus " type="checkbox" value="1">&nbsp;&nbsp;&nbsp; Показвать статус</p>
            <p><input class="checkDeliverMsg " type="checkbox" value="1">&nbsp;&nbsp;&nbsp; Сообщать о получении сообщения</p>
            <p><input class="checkViewMsg    " type="checkbox" value="1">&nbsp;&nbsp;&nbsp; Сообщать о просмотре сообщения</p>
            <p><input class="checkPrintText  " type="checkbox" value="1">&nbsp;&nbsp;&nbsp; Сообщать о наборе текста      </p>
        </div>
        <div style="margin-top: 25px">
            <div class="msgToAdmin">
                <img src="/service_img/design/submenu.gif" style="height: 20px;width: 20px; display: inline-block"/>
                <a style="display: inline-block; position: relative; bottom: 5px; font-size: larger">Написать администратору</a>
            </div>

            <div class="msgToAdminForm" style="display: none; text-align: center; padding-right: 5%; padding-left: 5%">
                <textarea class="content"  placeholder="Ваше сообщение администратору"></textarea>
                <div class="bt_send stlBtSmall">Отправить</div>
            </div>
            <div class="underline"></div>
        </div>
        <div id="settingPageContent" style="position: relative;"></div><br>
    </div>

    <?
        global $G;
        if($G->user_id == 1){
            echo '<br>';
            echo '<input type="button" class="buttonGenerateAds">';
        }
    ?>
</div>




<?

    $sel_arr[] = 'checkDeliverMsg';
    $sel_arr[] = 'checkViewMsg';
    $sel_arr[] = 'checkPrintText';
    $sel_arr[] = 'checkShowStatus';

    $sel_arr[] = 'msgToAdmin';
    $sel_arr[] = 'fqAboutRegistration';
    $sel_arr[] = 'fqAddAds';
    $sel_arr[] = 'fqRemoveAds';
    $sel_arr[] = 'fqRemoveMsg';
    $sel_arr[] = 'fqSecurity';
    $sel_arr[] = 'fqAboutProject';
    $sel_arr[] = 'bt_send';
    $sel_arr[] = 'notifyType';
    new \jsFuncClick('layoutSetting', $sel_arr, 'layoutSetting');

