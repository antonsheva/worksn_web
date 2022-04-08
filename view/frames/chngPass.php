<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class chngPass{
    public function __construct($id = 'chngPass')
    {
    ?>
        <div id="<?echo $id?>">
            <div class="bt_visible stlBtSmall" style="display: block">Смена пароля</div>
            <div class="visible" id="new_pass_hidden" style="display: none">
                <a style="font-size: larger">Смена пароля</a><br>
                <div class="padd_5"><input class="password" type="password" placeholder="Старый пароль"><div class="underLine"></div></div>
                <div class="padd_5"><input class="new_pass" type="password" placeholder="Новый пароль"><div class="underLine"></div></div>
                <div class="padd_5"><input class="rpt_pass" type="password" placeholder="Новый пароль еще раз"><div class="underLine"></div></div>
                <div class="bt_send stlBtSmall">Изменить пароль</div>
            </div>
        </div>
    <?

        $sel_arr[] = 'bt_visible';
        $sel_arr[] = 'bt_send';
        new \jsFuncClick($id, $sel_arr, 'chngPass');
    }
}
