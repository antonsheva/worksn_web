<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}
class frmAdsParameter{
    public function __construct($id = 'myButton'){?>
        <table style="width: 100%; height: 100%; margin-top: 1%">
            <tr id="myButton" class="myButton">
                <td class="adsParamCategory" style="width: 33%;">
                    <div class="bt1">
                        <h2 style="font-size: medium">Все категории</h2>
                    </div>
                </td>
                <td class="adsParamUser" style="width: 33%;">
                    <div class="bt1">
                        <h2 style="font-size: medium">Все пользователи</h2>
                    </div>
                </td>
                <td class="adsParamAddAds" style="width: 33%;">
                    <div class="bt1">
                        <h2 style="font-size: medium">Добавить объявление</h2>
                    </div>
                </td>
            </tr>
        </table>
        <?
        $sel[] = 'adsParamCategory';
        $sel[] = 'adsParamUser';
        $sel[] = 'adsParamAddAds';
//        $sel[] = 'adsParamSearch';
        new \jsFuncClick($id, $sel, 'myButton');
    }
}