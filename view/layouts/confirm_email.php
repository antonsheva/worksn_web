<?php
if($A_start != 444){echo 'byby';exit();}
global $G, $A_db, $U;


  $email = $U->confirmEmail();
  if ($email){
        $response  = 'Почта: <b>'.$email.'</b> подтверждена.'.PHP_EOL;
        $response .= 'Теперь Вы сможете восстановить доступ к своему аккаунту на WORKSN.RU';
    } else {
        $response  = 'Что-то пошло не так. <br> Попробуйте заново зарегистрировать почтовый ящик.';
    }
?>
<a class="hrefButton" href="/">На главную</a>
<div style="width: 100%; position: relative; top: 100px; text-align: center; font-size: larger"><?echo $response?></div>

<?
exit();
