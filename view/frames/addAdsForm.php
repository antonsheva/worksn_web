<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class addAdsForm{
    public function __construct($id = 'addAdsForm'){
        global $G;
        if($G->user->id)$placeholder = STRING_ADS_TXT;
        else            $placeholder = STRING_SIGN_IN_OR_UP;
        $attr = $G->user->id ? '' : 'disabled="disable"';
        ?>
        <div id="addAdsForm">
            <table class="str1">
                <tr style="width: 100%; height: 100%">
                    <td class="lifetime" style="width: 30%; height: 100%"><?echo STRING_ACTUALITY?></td>
                    <td style="width: 15%; text-align: left; position: relative">
                        <div style="text-align: center; width: 100%; height: 80%; position: relative"><img class="gallerySign" src="<?echo URL_IMG_GALLERY?>"></div>
                    </td>
                    <td style="width: 30%">
                        <div class="sendingImgs"></div>
                    </td>
                    <td class="cancel" style="width: 20%"><b style="font-size: larger; color: #777777"><?echo STRING_CANCEL?></b></td>
                </tr>
            </table>
            <table class="str2">
                <tr>
                    <td style="height: 20%; width: 20%">
                        <input class="cost" style="width: 100%" maxlength="8"  type="tel" pattern="[0-9]"  placeholder= <?echo STRING_COST_R.$attr?>>
                    </td>

                    <td style="width: 60%; text-align: right; padding-right: 2%">
                        <a style="color: #777777; font-size: larger">актуально с </a>
                        <select class="tmHourStart" style="text-align: right;">
                            <option value="0" >00</option>
                            <option value="1" >01</option>
                            <option value="2" >02</option>
                            <option value="3" >03</option>
                            <option value="4" >04</option>
                            <option value="5" >05</option>
                            <option value="6" >06</option>
                            <option value="7" >07</option>
                            <option value="8" >08</option>
                            <option value="9" >09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                        </select>
                        <a style="display: inline-block; font-size: larger;color: #777777 ">:</a>
                        <select class="tmMinStart" style="text-align: left; ">
                            <option value="00">00</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                        </select>
                       <a style="color: #777777; font-size: larger"> до</a>
                        <select class="tmHourStop" style="text-align: right;">
                            <option value="0" >00</option>
                            <option value="1" >01</option>
                            <option value="2" >02</option>
                            <option value="3" >03</option>
                            <option value="4" >04</option>
                            <option value="5" >05</option>
                            <option value="6" >06</option>
                            <option value="7" >07</option>
                            <option value="8" >08</option>
                            <option value="9" >09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                        </select>
                        <a style="display: inline-block; font-size: larger;color: #777777 ">:</a>
                        <select class="tmMinStop" style="text-align: left; ">
                            <option value="00">00</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="height: 70%; width: 100%">
                        <textarea class="description"  placeholder="<?echo $placeholder?>" style="resize: none; height: 100%; width: 100%" <?echo $attr?>></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <?

        $sel_click[] = 'chsCategory';
        $sel_click[] = 'lifetime';
        $sel_click[] = 'sendAds';
        $sel_click[] = 'sendingImgs';
        $sel_click[] = 'cancel';
        $sel_click[] = 'gallerySign';

        new \jsFuncClick($id, $sel_click, 'addAdsForm');
    }
}
