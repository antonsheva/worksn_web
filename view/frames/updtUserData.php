<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class updtUserData{
    public function __construct($id = 'updtUserData')
    {
        ?>

        <div id="updtUserData">
            <div class="padd_5"><input class="login"    type="text" placeholder="login" disabled="disabled"><div class="underLine"></div></div>
            <div class="padd_5"><input class="name"     type="text" placeholder="Имя"><div class="underLine"></div></div>
            <div class="padd_5"><input class="s_name"   type="text" placeholder="Фамилия"><div class="underLine"></div></div>
            <div class="padd_5"><input class="email"    type="text" placeholder="Email"><div class="underLine"></div></div>
            <div class="padd_5"><textarea class="about_user" placeholder="Тут Вы можете рассказать о себе"></textarea></div>
            <div class="bt stlBtSmall">Сохранить изменения</div>
        </div>
        <?php
        $sel_arr[] = 'bt';
        new \jsFuncClick($id, $sel_arr, 'updtUserData');
    }
}