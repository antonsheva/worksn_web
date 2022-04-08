<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class ratingStars
{
    public function __construct($rating, $ht=10)
    {?>
        <div class="ratingStars">
                <img class="smallStars" style="height: <?echo $ht?>px" src="../../../service_img/design/stars_bad_bgrd.gif">
                <img class="slider" style="height: <?echo $ht?>px; width: <?echo $rating/5?>%" src="../../../service_img/design/stars_ok_bgrd.gif" >
                <img class="smallStars" style="height: <?echo $ht?>px" src="../../../service_img/design/stars.gif">
        </div>
    <?}
}