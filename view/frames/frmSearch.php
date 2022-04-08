<?php
use structsPhp\G;
use structsPhp\StructUser;



class frmSearch{
    function __construct($id = 'frmSearch'){?>
        <div id="frmSearch" >
            <table>
                <tr style="width: 100%">
                    <td style="width: 100%">
                        <input class="content" type="text" placeholder="Давайте поищем" style="width: 100%; font-size: larger">
                    </td>
                    <td style="width: 20%">
                        <input class="bt" type="button" value="Найти"  style="width: 100%; font-size: larger">
                    </td>
                </tr>
            </table>
        </div>
  <?
        $sel_arr[] = 'bt';
        new \jsFuncClick($id, $sel_arr, 'frmSearch');
    }
}