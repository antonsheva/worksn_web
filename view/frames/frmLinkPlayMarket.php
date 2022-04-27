<?php

namespace framesView;


class frmLinkPlayMarket
{
    function __construct(){
        ?>
        <div class="linkGooglePlay">
            <a href="<?echo LINK_G_PLAY?>">
                <img src="<?echo URL_IMG_GOOGLE_PLAY?>">
            </a>
        </div>
        <?
    }
}