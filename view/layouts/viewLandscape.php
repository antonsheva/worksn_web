<?global $G?>
<a>...</a><br>
<div class="mainScreen">
    <div class="windowUserMenu" style="height: 7%; display: block; min-height: 80px">
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
    <div class="activeLabel">label</div>
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