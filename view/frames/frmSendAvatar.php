<?
namespace framesView;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class frmSendAvatar{
    function __construct(){
        global $S;?>
        <form  method="post" id="add_avatar" enctype="multipart/form-data" class="multi_pt" style="display: none">
            <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
            <input class="chs_file" name="userfile" type="file" onchange="CheckImgFile(this)" value=""/><br>
            <input type="hidden" name="act" value="<?echo ACT_ADD_IMG?>">
            <input type="hidden" name="ws_token" value="<?echo $S->AGet(STR_WS_TOKEN)?>">
            <input type="hidden" name="latin_filename" value="">
        </form>
        <?
    }
}

