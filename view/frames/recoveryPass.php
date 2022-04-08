<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class recoveryPass
{
    public function __construct($id = 'recoveryPass')
    {?>
        <div id="<?echo $id?>">
            <a>Введите Вашу почту</a><br><br>
            <div class="padd_5"><input class="email"    type="email" placeholder="Почта, указанная при регистрации"><div class="underLine"></div></div>
            <div class="bt stlBtSmall">Отправить</div>
        </div>
        <?
        $sel_arr[] = 'bt';
        new \jsFuncClick($id, $sel_arr, 'recoveryPass');
    }
}