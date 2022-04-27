<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 27.04.2022
 * Time: 13:22
 */

namespace framesView;


class frmSignGooglePlay{
    function __construct(){
        ?>
        <td style="width: 12.6%; height: 100%;" class="q2">
            <a href="<?echo LINK_G_PLAY?>">
                <img src="<?echo URL_SIGN_G_PLAY?>"/>
            </a>
        </td>
        <?
    }
}