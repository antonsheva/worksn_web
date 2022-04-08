<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class setAdsType{
    public function __construct(){?>
        <div id="adsType">
            <table  style="width: 100%">
                <tr style="width: 100%">
                    <td class="chsBtn btWorker">E</td>
                    <td class="chsBtn btEmployer">W</td>
                </tr>
            </table>
        </div>
        <?
   }
}