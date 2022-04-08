<? if($A_start != 444){echo 'byby';exit();}
global $S;
?>
<form  method="post" id="add_avatar" enctype="multipart/form-data" class="multi_pt" style="display: none">
    <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
    <input class="chs_file" name="userfile" type="file" onchange="CheckImgFile(this)" value=""/><br>
    <input type="hidden" name="act" value="add_img">
    <input type="hidden" name="s_token" value="<?echo $S->AGet('s_token')?>">
    <input type="hidden" name="latin_file_name" value="">
</form>