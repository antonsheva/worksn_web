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
    function __construct()
    {


    }
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
            case 'edit_ads'                     : $this->addPack_EditAds();            break;
            case 'set_bw_status'                : $this->addPack_SetBwStatus();        break;
            case 'get_env_data'                 : $this->addPack_GetEnvData();         break;
            case 'get_setting_data'             : $this->addPack_GetSettingPageData(); break;
            case 'get_user_data'                : $this->addPack_GetUserData();        break;
            case 'login'                        : $this->addPack_Login();              break;
            case 'anonym_login'                 : $this->addPack_Anonym();             break;
            case 'exit'                         : $this->addPack_Exit();               break;
            case 'chng_password'                : $this->addPack_ChngPassword();       break;
            case 'recovery_password'            : $this->addPack_RecoveryPassword();   break;
            case  ACT_UPDATE_USER_DATA          : $this->addPack_UpdtUserData();       break;
            case  ACT_UPDATE_AUTO_AUTH_DATA     : $this->addPack_UpdtAutoAuthData();   break;
            case 'reg_new_user'                 : $this->addPack_RegNewUser();         break;
            case 'add_user_review'              : $this->addPack_UserReview();         break;
            case 'get_user_reviews'             : $this->addPack_GetUserReviews();     break;

            case 'get_ads_collection'           : $this->addPack_GetAdsCollection();   break;
            case 'add_ads'                      : $this->addPack_AddAds();             break;
            case 'update_ads'                   : $this->addPack_UpdateAds();          break;
            case 'hidden_ads'                   : $this->addPack_HiddenAds();          break;
            case 'show_ads'                     : $this->addPack_ShowAds();            break;
            case 'rmv_ads'                      : $this->addPack_RmvAds();             break;
            case 'recovery_ads'                 : $this->addPack_RmvAds();             break;
            case 'add_msg'                      : $this->addPack_AddMsg();             break;
            case 'check_new_msg'                : $this->addPack_CheckNewMsg();        break;
            case 'get_user_msg'                 : $this->addPack_GetUserMsg();          break;
            case 'get_new_msg'                  : $this->addPack_GetNewMsg();          break;
            case 'get_all_msg'                  : $this->addPack_GetAllMsg();          break;
            case 'get_chain_msg'                : $this->addPack_GetChainMsg();        break;
            case 'get_discus_for_ads'           : $this->addPack_GetDiscusForAds();    break;
            case 'rmv_msg'                      : $this->addPack_RmvMsg();             break;
            case 'rmv_discus'                   : $this->addPack_RmvDiscus();          break;
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
        $this->data['img_list'] = $G->img_list;
    }
    function addPack_RemoveTmpFileList(){
      return;

    }
    function addPack_HiddenAds(){
        global $G;
        $this->data['target_ads'] = $G->targetAds;
    }
    function addPack_ShowAds(){
        global $G;
        $this->data['target_ads'] = $G->targetAds;
    }
    function addPack_UpdateAds(){
        global $G;
        $this->data['target_ads'] = $G->targetAds;
    }
    function addPack_CheckNewNotify(){
        return;
    }
    function addPack_GetNewNotify(){
        global $G;
        $this->data['notifies'] = $G->notifies;
        return;
    }
    function addPack_Login(){
        global $G;
        $this->data['user']           = $G->user;
    }
    function addPack_Anonym(){
        global $G;
        $this->data['user']           = $G->user;
    }
    function addPack_GetBanUsers(){
        global $G;
        $this->data['users_list']  = $G->usersList;
    }
    function addPack_GetLikeUsers(){
        global $G;
        $this->data['users_list']  = $G->usersList;
    }
    function addPack_SetBwStatus(){
        global $G;
        $this->data['ban_list']  = $G->user->ban_list;
        $this->data['like_list'] = $G->user->like_list;
    }
    function addPack_GetEnvData(){
        global $G;
        $envData = new EnvData();
        $this->data['user']              = $G->user;
//        $this->data['cat_list']          = $G->catList;
//        $this->data['lifetime_list']     = $G->lifetimeList;
//        $this->data['lifetime_names']    = $G->lifetimeNames;
        $this->data['have_sys_notify']   = $G->haveSysNotify;
        $this->data['setting_page_data'] = $envData->getSettingPageData();
        $this->data['lifetime']          = $envData->getLifetime();
        $this->data['categories']        = $envData->getCategories();
    }
    function addPack_GetSettingPageData(){
        $envData = new EnvData();
        $this->data['setting_page_data'] = $envData->getSettingPageData();
    }
    function addPack_GetUserData(){
        global $G;
        $this->data['user']           = $G->user;
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
        $this->data['user']           = $G->user;
    }
    function addPack_UpdtAutoAuthData(){
        global $G;
        $this->data['user']           = $G->user;
    }
    function addPack_RegNewUser(){
        global $G;
        $this->data['user']           = $G->user;
    }
    function addPack_RecoveryPassword(){
        return;
    }
    function addPack_UserReview(){
        global $G;
        $this->data['review'] = $G->userReview;
        $this->data['float_data'] = $G->owner->rating;
        $this->data['integer_data'] = $G->owner->vote_qt;
    }
    function addPack_GetUserReviews(){
        global $G;
        $this->data['review'] = $G->selfReview;
        $this->data['user_reviews'] = $G->userReviews;
        $this->data['owner'] = $G->owner;
    }
    function addPack_RmvTmpFile(){
        global $G;
        $this->data['tmp_img']      = $G->tmp_img;
        $this->data['tmp_img_icon'] = $G->tmp_img_icon;
    }
    function addPack_AddImg(){
        global $G, $P;
        $this->data['create_id']      = $P->AGet('create_id');
        $this->data['tmp_img']        = $G->tmp_img;
        $this->data['tmp_img_icon']   = $G->tmp_img_icon;
        $this->data['save_img_data']  = $G->saveImgData;
    }
    function addPack_GetAdsCollection(){
        global $G;
        $this->data['ads_collection'] = $G->adsCollection;         //---------------------------------------------------
    }
    function addPack_AddAds(){
        global $G;
        $this->data['target_ads'] = $G->targetAds;
    }
    function addPack_RmvAds(){
        return;
    }
    function addPack_RecoveryAds(){
        global $G;
        $this->data['target_ads'] = $G->targetAds;
    }
    function addPack_AddMsg(){
        global $G;
        $this->data['target_msg'] = $G->targetMsg;
    }
    function addPack_GetUserMsg(){
        global $G;
        $this->data['messages'] = $G->messages;   //$G->messages;         //---------------------------------------------------
    }
    function addPack_GetNewMsg(){
        global $G;
        $this->data['messages'] = $G->messages;   //$G->messages;         //---------------------------------------------------
    }
    function addPack_GetAllMsg(){
        global $G;
        $this->data['messages'] = $G->messages;   //$G->messages;         //---------------------------------------------------
    }
    function addPack_GetChainMsg(){
        global $G;
        $this->data['owner']      = $G->owner;
        $this->data['speaker']    = $G->speaker;
        $this->data['target_ads'] = $G->targetAds;
        $this->data['messages']   = $G->messages;   //$G->messages;         //---------------------------------------------------
        $this->data['discus']     = $G->discus;
    }
    function addPack_CheckNewMsg(){
        $this->data['test_data'] = 1;
    }
    function addPack_GetDiscusForAds(){
        global $G;
        $this->data['owner']      = $G->owner;
        $this->data['speaker']    = $G->speaker;
        $this->data['target_ads'] = $G->targetAds;
        $this->data['messages']   = $G->messages;         //---------------------------------------------------
        $this->data['discus']     = $G->discus;
    }
    function addPack_RmvMsg(){
        return;
    }
    function addPack_RmvDiscus(){
        return;
    }
    function addPack_Default(){
        global $G;

        if(($G->user->img == null)||($G->user->img == ""))$G->user->img = "../../../service_img/avatars/no-avatar.jpg";;
        $this->data['user']           = $G->user;
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



