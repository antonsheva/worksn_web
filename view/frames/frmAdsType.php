<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class frmAdsType{
    public function __construct($id = 'adsType'){?>
        <table id="adsType">
            <tr class="myButton">
                <td class="btWorker" style="width: 43%">
                    <div class="bt1" title="Свободные руки">Заказчик</div>
                </td>
                <td class="myLocation">
                    <div style="height: 100%; width: 100%">
                        <img  src="../../service_img/design/my_location.png">
                    </div>
                </td>
                <td class="btEmployer" style="width: 43%">
                    <div class="bt1" title="Подработка в свободное время">Работник</div>
                </td>
            </tr>
        </table>
        <?
        $sel[] = 'btWorker';
        $sel[] = 'btEmployer';
        $sel[] = 'myLocation';
        new \jsFuncClick($id, $sel, 'adsType');
    }
}