<?php
if($A_start != 444){echo 'byby';exit();}

class jsFuncChng{
    function  __construct($id, $sel_arr, $func_name){?>
        <script>
            $(window).load(function(){
                <?foreach ($sel_arr as $selector){
                    $fName = $func_name.'_'.$selector;?>
                    $('#<?echo $id?>   .<?echo $selector?>').on('change', function (target) {
                        <?echo $fName.'("'.$id.'")';?>
                    });
                <?}?>
            });
        </script>
    <?}
}