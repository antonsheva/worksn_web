<?php
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}


class frmHomeSign{
    function __construct()
    {?>
        <a class="homeSign" href="/">
            <img src="../../../service_img/design/home.png">
        </a>
    <?}
}

