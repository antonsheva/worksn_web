<?php
namespace classesPhp;
global $A_start;
if($A_start != 444){echo 'byby';exit();}

class ClassController{
    function __construct(){
        global $G, $M, $U, $AU, $A, $P, $AC_img, $AC_vote, $U_review;
        $act = $P->AGet('act');
        if($act){
            $G->act = $act;
            if ($G->user_id)$U->checkSessionToken($G->act);
            switch($act){

//-------------------   Crash application -------------------------------------------------
                case 'send_exception'     : saveCrashDataToFile();      break;
                case 'send_log_activity'  :saveLogActivityDataToFile(); break;
                case 'send_log_service'   :saveLogServiceDataToFile();  break;
//-------------------   Environment data    -----------------------------------------------

                case ACT_GET_ENVIRONMENT_DATA :getEnvData();            break;
                case ACT_REFRESH_SESSION      :refreshSession();        break;
                case 'get_setting_data'       :getSettingPageData();    break;

//-------------------   USER    ----------------------------------------------------------

                case 'login'              :$U->ALogin();                break;
                case 'anonym_login'       :$U->AAnonymLogin();          break;
                case 'exit'               :$U->AExit();                 break;
                case 'exit_android'       :$U->exitAndroid();           break;
                case 'chng_password'      :$U->AChangePassword();       break;
                case 'updt_user_data'     :$U->AUpdtUserData();         break;
                case 'updt_auto_auth_data':$U->AUpdateAutoAuthData();   break;
                case 'reg_new_user'       :$U->ARegistration();         break;
                case 'recovery_password'  :$U->ARecoveryPassword();     break;
                case 'get_user_data'      :$U->getUserData();           break;
                case ACT_CHECK_NEW_NOTIFY :$U->checkNewNotify();        break;
                case ACT_GET_NEW_NOTIFY   :$U->getNewNotify();          break;
                case ACT_GET_ALL_NOTIFY   :$U->getAllNotify();          break;

//-------------------   OWNER    ----------------------------------------------------------
                case 'set_bw_status'      :$U_review->setBwStatus();     break;
                case 'add_user_review'    :$U_review->addUserReview(); break;
                case 'get_user_reviews'   :$U_review->getUserData();     break;



// ------------------- BLACK/WHITE LIST -----------------------------------------------
                case ACT_GET_BAN_USERS    :$U_review->getBanUsers();     break;
                case ACT_GET_LIKE_USERS   :$U_review->getLikeUsers();    break;

//----------------------------  IMG  --------------------------------------------------
                case ACT_RMV_TMP_FILE_LIST :$AC_img->removeTmpFiles(); break;
                case ACT_RMV_FILE_LIST     :$AC_img->removeFileList(); break;
                case ACT_RMV_TMP_FILE      :$AC_img->removeTmpFile(); break;
                case ACT_ADD_IMG           :$AC_img->addImg();       break;

//-------------------   ADS  ----------------------------------------------------------
                case 'create_tmp_ads'     :$A->generateTmpAds();    break;
                case 'get_ads_collection' :$A->AGetAdsCollection(); break;
                case 'add_ads'            :$A->AAddAds();           break;
                case 'rmv_ads'            :$A->removeAds();           break;
                case 'update_ads'         :$A->updateAds();         break;
                case 'hidden_ads'         :$A->hiddenAds();         break;
                case 'show_ads'           :$A->showAds();           break;
                case 'recovery_ads'       :$A->recoveryAds();       break;
                case 'edit_ads'           :$A->editAds();           break;

//-------------------   MESSAGES   --------------------------------------------------------

                case 'add_msg'             :$M->AAddMsg();         break;
                case 'get_new_msg'         :$M->getNewMsg();       break;
                case 'get_all_msg'         :$M->getAllMsg();       break;
                case 'get_chain_msg'       :$M->getMsgChain();     break;
                case 'check_new_msg'       :$M->checkNewMsg();     break;
                case 'get_discus_for_ads'  :$M->getDiscusForAds(); break;
                case 'rmv_msg'             :$M->rmvMsg();          break;
                case 'rmv_discus'           :$M->rmvDiscus();       break;
                case 'get_user_msg'        :$M->getUserMsg();      break;

//-----------------------------------------------------------------------------------------

                default                    :{unset($_GET['page']); $P->clear();  mRESP_WTF();}
            }
        }
        else {
            $meta = $P->AGet('m');
            if ($meta)$this->routineCompressData();
        }
    }

    function routineCompressData(){
        global $G, $M, $U, $AU, $A, $P, $AC_img, $AC_vote, $U_review;
        $meta = $P->AGet('m');

        $act = substr($meta,0,1);
        if ($G->user_id)$U->checkToken($G->act);
        switch ($act){
            case ACT_ADD_MSG          : $M->AAddMsg();
        }
    }
}




















