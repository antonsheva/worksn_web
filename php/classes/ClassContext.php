<?php
namespace classesPhp;
global $A_start;

use function Sodium\add;
use structsPhp\EnvData;
use structsPhp\G;

if($A_start != 444){echo 'byby';exit();}

class ClassContext
{
    var $data = array();
    var $token = null;
    var $nullObgQt = 0;
    var $tmpArr = array();
    function __construct(){}
    function  ACreateContext(){
        global $G, $S;
        unset($G->user->password);
        unset($G->user->cookie_pass);
        unset($G->user->email_hash);
        $this->data = array();
        switch($G->act){
            case ACT_REFRESH_SESSION            : $this->addPack_RefreshSession();     break;
            case ACT_RMV_TMP_FILE_LIST          : $this->addPack_RemoveTmpFileList();  break;
            case ACT_RMV_TMP_FILE               : $this->addPack_RmvTmpFile();         break;
            case ACT_ADD_IMG                    : $this->addPack_AddImg();             break;
            case ACT_ADS_EDIT                   : $this->addPack_EditAds();            break;
            case ACT_SET_BW_STATUS              : $this->addPack_SetBwStatus();        break;
            case ACT_GET_ENVIRONMENT_DATA       : $this->addPack_GetEnvData();         break;
            case ACT_GET_SETTING_DATA           : $this->addPack_GetSettingPageData(); break;
            case ACT_GET_USER_DATA              : $this->addPack_GetUserData();        break;
            case ACT_LOGIN                      : $this->addPack_Login();              break;
            case ACT_ANONYMOUS_LOGIN            : $this->addPack_Anonym();             break;
            case ACT_EXIT                       : $this->addPack_Exit();               break;
            case ACT_CHNG_PASSWORD              : $this->addPack_ChngPassword();       break;
            case ACT_RECOVERY_PASSWORD          : $this->addPack_RecoveryPassword();   break;
            case ACT_UPDATE_USER_DATA           : $this->addPack_UpdtUserData();       break;
            case ACT_UPDATE_AUTO_AUTH_DATA      : $this->addPack_UpdtAutoAuthData();   break;
            case ACT_REG_NEW_USER               : $this->addPack_RegNewUser();         break;
            case ACT_ADD_USER_REVIEW            : $this->addPack_UserReview();         break;
            case ACT_GET_USER_REVIEWS           : $this->addPack_GetUserReviews();     break;
            case ACT_GET_ADS_COLLECTION         : $this->addPack_GetAdsCollection();   break;
            case ACT_ADS_ADD                    : $this->addPack_AddAds();             break;
            case ACT_ADS_UPDATE                 : $this->addPack_UpdateAds();          break;
            case ACT_ADS_HIDDEN                 : $this->addPack_HiddenAds();          break;
            case ACT_ADS_SHOW                   : $this->addPack_ShowAds();            break;
            case ACT_ADS_REMOVE                 : $this->addPack_RmvAds();             break;
            case ACT_ADS_RECOVERY               : $this->addPack_RmvAds();             break;
            case ACT_ADD_MSG                    : $this->addPack_AddMsg();             break;
            case ACT_CHECK_NEW_MSG              : $this->addPack_CheckNewMsg();        break;
            case ACT_GET_USER_MSG               : $this->addPack_GetUserMsg();         break;
            case ACT_GET_NEW_MSG                : $this->addPack_GetNewMsg();          break;
            case ACT_GET_ALL_MSG                : $this->addPack_GetAllMsg();          break;
            case ACT_GET_CHAIN_MSG              : $this->addPack_GetChainMsg();        break;
            case ACT_GET_DISCUS_FOR_ADS         : $this->addPack_GetDiscusForAds();    break;
            case ACT_REMOVE_MSG                 : $this->addPack_RmvMsg();             break;
            case ACT_REMOVE_DISCUS              : $this->addPack_RmvDiscus();          break;
            case ACT_CHECK_NEW_NOTIFY           : $this->addPack_CheckNewNotify();     break;
            case ACT_GET_NEW_NOTIFY             : $this->addPack_GetNewNotify();       break;
            case ACT_GET_ALL_NOTIFY             : $this->addPack_GetNewNotify();       break;
            case ACT_GET_BAN_USERS              : $this->addPack_GetBanUsers();        break;
            case ACT_GET_LIKE_USERS             : $this->addPack_GetLikeUsers();       break;
            default :$this->addPack_Default();
        }
        $this->addServiceData();
    }

    function clearObject($obj){
        foreach ($obj as $item) {
            if ($item ==  null){
                unset($item);
                continue;
            }
            if ($item ==  ''){
                unset($item);
                continue;
            }
            if ($item ==  NULL){
                unset($item);
                continue;
            }
            if ($item ==  'null'){
                unset($item);
                continue;
            }
        }
    }
    function clearArray($arr){
        foreach ($arr as $key=>&$item){
            if (is_object($item)&& !is_string($item))$this->clearObject($item);
            if (is_array($item))$this->clearArray($item);
            if ($item == null)unset($item);
        }
    }


    function addPack_RefreshSession(){
          return;
    }
    function addPack_EditAds(){
        global $G;
        $this->data[STR_IMG_LIST] = $G->img_list;
    }
    function addPack_RemoveTmpFileList(){
      return;

    }
    function addPack_HiddenAds(){
        global $G;
        $this->data[STR_TARGET_ADS] = $G->targetAds;
    }
    function addPack_ShowAds(){
        global $G;
        $this->data[STR_TARGET_ADS] = $G->targetAds;
    }
    function addPack_UpdateAds(){
        global $G;
        $this->data[STR_TARGET_ADS] = $G->targetAds;
    }
    function addPack_CheckNewNotify(){
        return;
    }
    function addPack_GetNewNotify(){
        global $G;
        $this->data[STR_NOTIFIES] = $G->notifies;
        return;
    }
    function addPack_Login(){
        global $G;
        $this->data[STR_USER]           = $G->user;
    }
    function addPack_Anonym(){
        global $G;
        $this->data[STR_USER]           = $G->user;
    }
    function addPack_GetBanUsers(){
        global $G;
        $this->data[STR_USERS_LIST]  = $G->usersList;
    }
    function addPack_GetLikeUsers(){
        global $G;
        $this->data[STR_USERS_LIST]  = $G->usersList;
    }
    function addPack_SetBwStatus(){
        global $G;
        $this->data[STR_BAN_LIST]  = $G->user->ban_list;
        $this->data[STR_LIKE_LIST] = $G->user->like_list;
    }
    function addPack_GetEnvData(){
        global $G;
        $envData = new EnvData();
        $this->data[STR_USER]              = $G->user;
        $this->data[STR_HAVE_SYS_NOTIFY]   = $G->haveSysNotify;
        $this->data[STR_SETTING_PAGE_DATA] = $envData->getSettingPageData();
        $this->data[STR_LIFETIME]          = $envData->getLifetime();
        $this->data[STR_CATEGORIES]        = $envData->getCategories();
    }
    function addPack_GetSettingPageData(){
        $envData = new EnvData();
        $this->data[STR_SETTING_PAGE_DATA] = $envData->getSettingPageData();
    }
    function addPack_GetUserData(){
        global $G;
        $this->data[STR_USER]           = $G->user;
    }
    function addPack_FullPage(){

    }
    function addPack_Exit(){
        return;
    }
    function addPack_ChngPassword(){
        return;
    }
    function addPack_UpdtUserData(){
        global $G;
        $this->data[STR_USER]           = $G->user;
    }
    function addPack_UpdtAutoAuthData(){
        global $G;
        $this->data[STR_USER]           = $G->user;
    }
    function addPack_RegNewUser(){
        global $G;
        $this->data[STR_USER]           = $G->user;
    }
    function addPack_RecoveryPassword(){
        return;
    }
    function addPack_UserReview(){
        global $G;
        $this->data[STR_USER] = $G->userReview;
        $this->data[STR_FLOAT_DATA] = $G->owner->rating;
        $this->data[STR_INTEGER_DATA] = $G->owner->vote_qt;
    }
    function addPack_GetUserReviews(){
        global $G;
        $this->data[STR_REVIEW] = $G->selfReview;
        $this->data[STR_USER_REVIEWS] = $G->userReviews;
        $this->data[STR_OWNER] = $G->owner;
    }
    function addPack_RmvTmpFile(){
        global $G;
        $this->data[STR_TMP_IMG]      = $G->tmp_img;
        $this->data[STR_TMP_IMG_ICON] = $G->tmp_img_icon;
    }
    function addPack_AddImg(){
        global $G, $P;
        $this->data[STR_CREATE_ID]      = $P->AGet(STR_CREATE_ID);
        $this->data[STR_TMP_IMG]        = $G->tmp_img;
        $this->data[STR_TMP_IMG_ICON]   = $G->tmp_img_icon;
        $this->data[STR_SAVE_IMG_DATA]  = $G->saveImgData;
    }
    function addPack_GetAdsCollection(){
        global $G;
        $this->data[STR_ADS_COLLECTION] = $G->adsCollection;         //---------------------------------------------------
    }
    function addPack_AddAds(){
        global $G;
        $this->data[STR_TARGET_ADS] = $G->targetAds;
    }
    function addPack_RmvAds(){
        return;
    }
    function addPack_RecoveryAds(){
        global $G;
        $this->data[STR_TARGET_ADS] = $G->targetAds;
    }
    function addPack_AddMsg(){
        global $G;
        $this->data[STR_TARGET_MSG] = $G->targetMsg;
    }
    function addPack_GetUserMsg(){
        global $G;
        $this->data[STR_MESSAGES] = $G->messages;   //$G->messages;         //---------------------------------------------------
    }
    function addPack_GetNewMsg(){
        global $G;
        $this->data[STR_MESSAGES] = $G->messages;   //$G->messages;         //---------------------------------------------------
    }
    function addPack_GetAllMsg(){
        global $G;
        $this->data[STR_MESSAGES] = $G->messages;   //$G->messages;         //---------------------------------------------------
    }
    function addPack_GetChainMsg(){
        global $G;
        $this->data[STR_OWNER]      = $G->owner;
        $this->data[STR_SPEAKER]    = $G->speaker;
        $this->data[STR_TARGET_ADS] = $G->targetAds;
        $this->data[STR_MESSAGES]   = $G->messages;   //$G->messages;         //---------------------------------------------------
        $this->data[STR_DISCUS]     = $G->discus;
    }
    function addPack_CheckNewMsg(){
        $this->data[STR_TEST_DATA] = 1;
    }
    function addPack_GetDiscusForAds(){
        global $G;
        $this->data[STR_OWNER]      = $G->owner;
        $this->data[STR_SPEAKER]    = $G->speaker;
        $this->data[STR_TARGET_ADS] = $G->targetAds;
        $this->data[STR_MESSAGES]   = $G->messages;         //---------------------------------------------------
        $this->data[STR_DISCUS]     = $G->discus;
    }
    function addPack_RmvMsg(){
        return;
    }
    function addPack_RmvDiscus(){
        return;
    }
    function addPack_Default(){
        global $G;

        if(($G->user->img == null)||($G->user->img == ""))$G->user->img = "../../../service_img/avatars/no-avatar.jpg";
        $this->data[STR_USER]           = $G->user;
        $this->data['owner']          = $G->owner;
        $this->data['ads_type']       = $G->ads_type;
        $this->data['ads_category']   = $G->ads_category;
        $this->data['ads_owner_id']   = $G->ads_owner_id;
        $this->data['ads_collection'] = $G->adsCollection;         //---------------------------------------------------
        $this->data['messages']       = $G->messages;   //$G->messages;              //---------------------------------------------------
        $this->data['target_ads']     = $G->targetAds;
        $this->data['target_msg']     = $G->targetMsg;
        $this->data['review']         = $G->selfReview;
        $this->data['user_reviews']   = $G->userReviews;
        $this->data['discus']         = $G->discus;
        $this->data['cat_list']       = $G->catList;
        $this->data['lifetime_list']  = $G->lifetimeList;
        $this->data['lifetime_names'] = $G->lifetimeNames;
        $this->data['tmp_img']        = $G->tmp_img;
        $this->data['tmp_img_icon']   = $G->tmp_img_icon;
        $this->data['have_sys_notify']= $G->haveSysNotify;
        $this->data['test_data']      = $G->test_data;
    }

    function addServiceData(){
        global $G;
        $this->data['page_name']      = $G->location_page;
        $this->data['mode']           = $G->mode;
        $this->data['date']           = $G->date;
        $this->data['date_full']      = $G->dateFull;
        $this->data['nSecTime']       = $G->nSecTime;

    }
    function APrintContext(){
        $this->ACreateContext();
        $this->clearArray($this->data);

        $json = json_encode($this->data, JSON_FORCE_OBJECT);
        $json  = '<script type="text/javascript"> var StructContext = '.$json.'</script>';
        echo $json;
    }
    function ACheckShowMap(){
        global $G;
        $arr[] = 'home';
        if(in_array($G->location_page, $arr))$this->data['show_map'] = 1;
    }
}



