//   ------   ON_CLICK FUNCS    ------------------------------------------------
function imgBox_cls(id)             {removeImg(G_tmp_img)}
// function imgBox_img(id)             {sendFile()}
function regForm_bt(id)             {ASendRegForm(GP(id))}

function loginForm_anonym(id, obj)  {AAnonymLogin(obj)}

function chngPass_bt_visible()      {AShowNewPass()}
function chngPass_bt_send(id)       {chngPass(GP(id))}
function updtUserData_bt(id)        {updtUserData(GP(id))}
function updtAutoAuthData_bt(id)    {updtAutoAuthData(GP(id))}
function recoveryPass_bt(id)        {recoveryPass(GP(id))}

function adsParameterReset_bt(id)   {adsParameterReset()}


//---------  SEND MSG  ----------------------------------------------------------
function sendMsg_btSend(id)         {sendMsg(GP(id))}
function sendMsg_gallerySign(id)    {chooseImg(id)}
function sendImgMsg_bt(id)          {sendMsg(GP(id))}


//--------- LOGIN FORM ----------------------------------------------------------
function loginForm_password() { }
function loginForm_login() { }
function loginForm_bt(id)           {ALogin(GP(id))}

function userProfile_bt(id)         {sendUserReviewTxt(GP(id))}
function userProfile_star(id, obj)  {userVote($(obj).data('star_numb'))}
function userProfile_href()         { }
function userProfile_ban()          {switchBan()}
function userProfile_like()         {switchLike()}
function userProfile_avatarImg(id)  {showBigAvatar()}

function userProfile_messages()     {showDiscusesWithUser()}



//--------- SUB MENU ------------------------------------------------------------
function subMenu_remove(id)         {subMenuRemove()}
function subMenu_recovery(id)       {subMenuRecoveryAds()}
function subMenu_hidden(id)         {subMenuHiddenAds()}
function subMenu_show(id)           {subMenuShowAds()}
function subMenu_edit(id)           {subMenuEditAds()}
function subMenu_copy(id)           {subMenuCopy()}
function subMenu_reply(id)          {subMenuReply()}


//--------- USER MENU -----------------------------------------------------------
function userMenu_exit(id)          {AExit(true)}
function userMenu_allMsg(id)        {getMsgGroup('get_all_msg')}
function userMenu_newMsg(id)        {getMsgGroup('get_new_msg');}
function userMenu_like(id)          {getLikeUsers()}
function userMenu_ban(id)           {getBanUsers()}
function userMenu_setting(id)       {}


//--------- ADS PARAMETER -------------------------------------------------------
function myButton_adsParamCategory(id, obj){choiceAdsCategory();}
function myButton_adsParamUser(id, obj)    {choiceAdsUser();}
function myButton_adsParamAddAds(id, obj)  {choiceEditAdsAdd(id, obj);}

//--------- ADS TYPE ------------------------------------------------------------
function adsType_btWorker()   {selAdsType(C_TYPE_WORKER, true)}
function adsType_btEmployer() {selAdsType(C_TYPE_EMPLOYER, true)}
function adsType_myLocation() {setCenterToMyLocation(true)}

//--------- ADD ADS  ------------------------------------------------------------
function addAdsForm_lifetime(id, obj)    {renderScreenSelectLifetime()}
function addAdsForm_sendAds(id, obj)     {addAds(GP(id))}
function addAdsForm_sendingImgs()        {renderTmpImgGroup(1)}
function addAdsForm_cancel()             {cancelAddAdsMode()}
function addAdsForm_gallerySign(id)        {chooseImg(id)}



//--------- SEARCH  -------------------------------------------------------------
function frmSearch_bt(id, obj) {searchAds(GP(id))}

//-------------------------------------------------------------------------------
function frmDiscusCard_adsData()            {renderMessagesScreen()}
function frmDiscusCard_expand()             {renderMessagesScreen()}
function frmDiscusCard_roll ()              {renderRollDiscus()}
function frmDiscusCard_loadImgs ()          {showImgArray()}

//-------------------------------------------------------------------------------


//--------- layoutSetting -------------------------------------------------------
function layoutSetting_msgToAdmin()         {expandMsgToAdmin()}
function layoutSetting_fqAboutRegistration(){expandFqAboutRegistration()}
function layoutSetting_fqAddAds()           {expandFqAddAds()}
function layoutSetting_fqRemoveAds()        {expandFqRemoveAds()}
function layoutSetting_fqRemoveMsg()        {expandFqRemoveMsg()}
function layoutSetting_fqSecurity()         {expandFqSecurity()}
function layoutSetting_fqAboutProject()     {expandFqAboutProject()}
function layoutSetting_bt_send(id)          {expandSendMsgToAdmin(GP(id))}

function layoutSetting_checkDeliverMsg()    {clickCheckDeliverMsg()}
function layoutSetting_checkViewMsg   ()    {clickCheckViewMsg()}
function layoutSetting_checkPrintText ()    {clickCheckPrintText()}
function layoutSetting_checkShowStatus ()   {clickCheckShowStatus()}
function layoutSetting_notifyType ()        {getAllNotifies()}


//--------- replyToMsgForm ---------------------------------------------------------
function replyToMsgForm_close(){hideReplyToMsgForm()}


