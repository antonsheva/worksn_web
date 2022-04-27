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
                case ACT_SEND_EXCEPTION           : saveCrashDataToFile();      break;
                case ACT_SEND_LOG_ACTIVITY        : saveLogActivityDataToFile(); break;
                case ACT_SEND_LOG_SERVICE         : saveLogServiceDataToFile();  break;
                case ACT_GET_ENVIRONMENT_DATA     : getEnvData();                break;
                case ACT_REFRESH_SESSION          : refreshSession();            break;
                case ACT_GET_SETTING_DATA         : getSettingPageData();        break;
                case ACT_LOGIN                    : $U->ALogin();                break;
                case ACT_ANONYMOUS_LOGIN          : $U->AAnonymLogin();          break;
                case ACT_EXIT                     : $U->AExit();                 break;
                case ACT_EXIT_ANDROID             : $U->exitAndroid();           break;
                case ACT_CHNG_PASSWORD            : $U->AChangePassword();       break;
                case ACT_UPDATE_USER_DATA         : $U->AUpdtUserData();         break;
                case ACT_UPDATE_AUTO_AUTH_DATA    : $U->AUpdateAutoAuthData();   break;
                case ACT_REG_NEW_USER             : $U->ARegistration();         break;
                case ACT_RECOVERY_PASSWORD        : $U->ARecoveryPassword();     break;
                case ACT_GET_USER_DATA            : $U->getUserData();           break;
                case ACT_CHECK_NEW_NOTIFY         : $U->checkNewNotify();        break;
                case ACT_GET_NEW_NOTIFY           : $U->getNewNotify();          break;
                case ACT_GET_ALL_NOTIFY           : $U->getAllNotify();          break;
                case ACT_SET_BW_STATUS            : $U_review->setBwStatus();    break;
                case ACT_ADD_USER_REVIEW          : $U_review->addUserReview();  break;
                case ACT_GET_USER_REVIEWS         : $U_review->getUserData();    break;
                case ACT_GET_BAN_USERS            : $U_review->getBanUsers();    break;
                case ACT_GET_LIKE_USERS           : $U_review->getLikeUsers();   break;
                case ACT_RMV_TMP_FILE_LIST        : $AC_img->removeTmpFiles();   break;
                case ACT_RMV_FILE_LIST            : $AC_img->removeFileList();   break;
                case ACT_RMV_TMP_FILE             : $AC_img->removeTmpFile();    break;
                case ACT_ADD_IMG                  : $AC_img->addImg();           break;
                case ACT_CREATE_TMP_ADS           : $A->generateTmpAds();         break;
                case ACT_GET_ADS_COLLECTION       : $A->AGetAdsCollection();      break;
                case ACT_ADS_ADD                  : $A->AAddAds();                break;
                case ACT_ADS_REMOVE               : $A->removeAds();              break;
                case ACT_ADS_UPDATE               : $A->updateAds();              break;
                case ACT_ADS_HIDDEN               : $A->hiddenAds();              break;
                case ACT_ADS_SHOW                 : $A->showAds();                break;
                case ACT_ADS_RECOVERY             : $A->recoveryAds();            break;
                case ACT_ADS_EDIT                 : $A->editAds();                break;
                case ACT_ADD_MSG                  : $M->AAddMsg();                break;
                case ACT_GET_NEW_MSG              : $M->getNewMsg();              break;
                case ACT_GET_ALL_MSG              : $M->getAllMsg();              break;
                case ACT_GET_CHAIN_MSG            : $M->getMsgChain();            break;
                case ACT_CHECK_NEW_MSG            : $M->checkNewMsg();            break;
                case ACT_GET_DISCUS_FOR_ADS       : $M->getDiscusForAds();        break;
                case ACT_REMOVE_MSG               : $M->rmvMsg();                 break;
                case ACT_REMOVE_DISCUS            : $M->rmvDiscus();              break;
                case ACT_GET_USER_MSG             : $M->getUserMsg();             break;

                default                    :{unset($_GET[STR_PAGE]); $P->clear();  mRESP_WTF();}
            }
        }
        else {
            $meta = $P->AGet('m');
            if ($meta)$this->routineCompressData();
        }
    }

    function routineCompressData(){
        global $G, $M, $U,$P;
        $meta = $P->AGet('m');
        $act = substr($meta,0,1);
        if ($G->user_id)$U->checkToken($G->act);
        switch ($act){
            case ACT_ADD_MSG          : $M->AAddMsg();
        }
    }
}




















