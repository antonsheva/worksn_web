<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class frmAdsType{
    public function __construct($id = 'adsType'){?>
        <table id="adsType">
            <tr class="myButton">
                <td class="btWorker" style="width: 43%">
                    <div class="bt1" title="<?echo STRING_FREE_HANDS?>"><?echo STRING_EMPLOYER?></div>
                </td>
                <td class="myLocation">
                    <div style="height: 100%; width: 100%">
                        <img  src="<?echo URL_IMG_MY_LOCATION?>">
                    </div>
                </td>
                <td class="btEmployer" style="width: 43%">
                    <div class="bt1" title="<?echo STRING_PART_TIME_JOB?>"><?echo STRING_WORKER?></div>
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