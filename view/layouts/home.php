<?global $G, $ROOT, $DIR;
$chck1 = '';
$chck2 = '';
if($G->ads_type==ADS_TYPE_EMPLOYER)
    $chck1 = 'checked';
else
    $chck2 = 'checked';
include 'www/view/forms/sendAvatar.php';?>
 
<div class="tmpImgBox">
    <?  $img = "../../../service_img/design/gallery.gif";
    new \framesView\imgBox($img );
    new \framesView\frmSendImageMsg();
    ?>
</div>

<div class="imgGrp">
    <img class="closeImgGroup" src="<?echo $DIR->design?>sn_down_azure.gif">
    <div class="tmpImgGroup"></div>
</div>
<div id="onClick"></div>
<?
    new \framesView\subMenu();
    $minHeight = $G->user->id ? '60px' : '100px';
?>

<div class="mainScreen" style="min-height: 600px">
        <div class="windowUserMenu" style="height: 7%; display: block; min-height: <?echo $minHeight?>">
            <?if($G->user->id) new \framesView\userMenu();
              else             new \framesView\frmLoginForm();?>
        </div>
        <div class="windowAdsType"       style="height: 7%;position: relative;">
            <?new \framesView\frmAdsType();?>
        </div>
        <div class="windowMap">
            <div id="map"></div>
        </div>
        <div class="windowAdsParameter"  style="height: 7%; display: block; position: relative">
            <?new \framesView\frmAdsParameter();?>
        </div>
        <h1 class="activeLabel">label</h1>
        <div class="windowActive" style="display: block; height: 35%; background-color: #c4d7e9;">

            <? new \framesView\frmActive()?>
        </div>
        <div class="windowDiscus" style="height: 82%; display: none; position: relative; top: 5px; width: 100%; overflow: auto">
            <?new \framesView\frmDiscusCard();?>
            <div class="fullDescription"></div>

            <div class="frmMsg">
                <div class="messagesFrame"></div>
                <? new \framesView\frmReplyToMsgForm();?>
            </div>
            <? new \framesView\frmSendMsgForm();?>
        </div>

        <div class="windowSearch" style="display: block; height: 5%; bottom: 5px;position: absolute">
            <?new \frmSearch();?>
        </div>
</div>




