<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}



class subMenu
{
    public function __construct($id='subMenu')
    {?>
        <table class="subMenu" id="subMenu">

            <tr align="center" class="remove" style="width: 100%">
                <td>Удалить</td>
            </tr>
            <tr align="center" class="recovery" style="width: 100%">
                <td>Восстановить</td>
            </tr>
            <tr align="center" class="hidden" style="width: 100%">
                <td >Скрыть</td>
            </tr>
            <tr align="center" class="show" style="width: 100%">
                <td>Показать</td>
            </tr>
            <tr align="center" class="edit" style="width: 100%">
                <td>Изменить</td>
            </tr>
            <tr align="center" class="copy" style="width: 100%">
                <td>Копировать</td>
            </tr>
            <tr align="center" class="reply" style="width: 100%">
                <td>Ответить</td>
            </tr>

        </table>
    <?
 
        $sel_arr[] = 'remove';
        $sel_arr[] = 'recovery';
        $sel_arr[] = 'hidden';
        $sel_arr[] = 'show';
        $sel_arr[] = 'edit';
        $sel_arr[] = 'copy';
        $sel_arr[] = 'reply';

        new \jsFuncClick($id, $sel_arr, 'subMenu', true);
    }

}