<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class regForm
{
    public function __construct($id = 'regForm')
    {?>
        <style>
            #regForm input{text-align: center}
        </style>
        <div id="regForm" style="">
            <div class="padd_5">  <input class="login"    type="text" placeholder="Придумайте логин"><div class="underLine"></div></div>
            <div class="padd_5">  <input class="password" type="password" placeholder="Придумайте пароль"><div class="underLine"></div></div>
            <div class="padd_5">  <input class="rpt_pass" type="password" placeholder="Повторите пароль"><div class="underLine"></div></div>
            <div class="padd_5">  <input class="name"     type="text" placeholder="Имя"><div class="underLine"></div></div>
            <div class="padd_5">  <input class="s_name"   type="text" placeholder="Фамилия"><div class="underLine"></div></div>
            <div class="padd_5">  <input class="email"    type="text" placeholder="Email (для восстановления доступа)"><div class="underLine"></div></div>
            <div class="padd_5">  <textarea class="about_user" placeholder="Тут Вы можете рассказать о себе"></textarea></div> 
            <div class="bt stlBtSmall">Отправить</div>
        </div>
        <?php
        $sel_arr[] = 'bt';
        new \jsFuncClick($id, $sel_arr, 'regForm');
    }
}