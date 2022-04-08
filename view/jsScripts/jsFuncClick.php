<?php
if($A_start != 444){echo 'byby';exit();}
class jsFuncClick{
    function  __construct($id, $sel_arr, $func_name, $chkTouch=null){?>
        <script>
            $(window).load(function(){
                <?foreach ($sel_arr as $selector){
                    $fName = $func_name.'_'.$selector;?>
                    $('#<?echo $id?>   .<?echo $selector?>').on('click <?if($chkTouch)echo 'touchend'?>', function (e) {
                        if ('ontouchstart' in window) {
                            <?echo $fName.'("'.$id.'", this, e)'?>
                        }else {
                            <?echo $fName.'("'.$id.'", this, e)'?>
                        }

                    });
                <?}?>
            });
        </script>
    <?}
}














