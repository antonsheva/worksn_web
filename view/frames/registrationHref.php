<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class registrationHref{
    function __construct(){?>
        <div id="registrationForm" style="width: 100%; height: 7%; ">
            <table class="tblRegForm" style="width: 100%; height: 50%">
                <tr>
                    <td style="width: 50%">
                        <div style="width: 100%; text-align: center">
                            <a class="registration" href="/registration" >Регистрация</a>
                        </div>
                    </td>
                    <td style="width: 50%">
                        <div style="width: 100%; text-align: center">
                            <a class="registration" href="/recovery"  >Забыли пароль?</a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    <?}
}