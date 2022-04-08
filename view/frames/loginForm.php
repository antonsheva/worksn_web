<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class loginForm{
    function __construct($id = 'loginForm'){
        ?>
        <div id="loginForm" style="width: 100%; height: 100%; ">
            <table class="roundSendForm" style="height: 50%; padding: 1%">
                <tr  style="width: 100%">
                    <td class="sendData" style="width: 30%">
                        <input class="login" type="text" placeholder="Логин"><br>
                    </td>
                    <td class="sendData" style="width: 30%">
                        <input class="password" type="password" placeholder="Пароль"><br>
                    </td>
                    <td  style="text-align: center; width: 20%;">
                        <div class="bt" style="font-size: x-large; font-weight: 600; color: #9d9f9d">
                            Войти
                        </div>
                    </td>
                </tr>
            </table>
            <div style="width: 80%; height: 1px; background-color: #9d9f9d; margin-left: 10%; "></div>
            <table class="tblRegForm" style="width: 100%; height: 50%">
                <tr>
                    <td style="width: 33%">
                        <div style="width: 100%; text-align: center">
                            <a class="registration" href="/registration" >Регистрация</a>
                        </div>
                    </td>
                    <td style="width: 33%">
                        <div style="width: 100%; text-align: center">
                            <a class="registration" href="/recovery"  >Забыли пароль?</a>
                        </div>
                    </td>
                    <td style="width: 33%">
                        <div style="width: 100%; text-align: center; font-size: x-large; font-weight: 600; color: #9d9f9d">
                            <a class="anonym">Аноним</a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <?
        $sel_arr[] = 'bt';
        $sel_arr[] = 'anonym';
        new \jsFuncClick($id, $sel_arr, 'loginForm');
    }
}

?>
