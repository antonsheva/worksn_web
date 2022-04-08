<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 31.01.2021
 * Time: 21:27
 */

namespace framesView;


class frmActive
{
    public function __construct(){?>

        <div id="msgWindow"     class="msg        activFrmContent">
            <div class="appendData"></div>
        </div>
        <div id="frmCategory"   class="category   activFrmContent"></div>
        <div id="frmLifetime"   class="lifetime   activFrmContent"></div>
        <div id="frmUsers"      class="users      activFrmContent">msgFrmUsers</div>
        <div id="frmAddAds"     class="addAds     activFrmContent"><?new addAdsForm()?></div>
        <div id="firstEntry"    class="firstEntry activFrmContent">
            <h2 style="color: rgb(76, 169, 84); margin-left: 5%; width: 88%">Оставьте объявление, чтоб его увидели те, кто рядом.</h2><br>
            <div style="position: relative; display: block; margin-left: 3%">
                <?include (__DIR__."/../html/linkPlayMarket.html");?>
            </div>

        </div>
        <div id="frmVisibleAds" class="visibleAds activFrmContent">
            <div class="appendData"></div>
        </div>
    <?}
}