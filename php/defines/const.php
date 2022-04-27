<?php
global $A_start;
if ($A_start !=  444) {echo BYBY; exit  ;}

const OK                          =   0 ;
const ERROR                       =  -1 ;
const ERR_USER_IS_NLL             =   1 ;
const ERR_DB_GET_MULTIPLE_DATA    =   2 ;
const ERR_DB_GET_SINGLE_DATA      =   3 ;
const ERR_DB_CONNECT              =   4 ;
const ERR_DB_QUERY                =   5 ;
const ERR_DB_INSERT               =   6 ;
const ERR_DB_UPDATE               =   7 ;
const ERR_FILE_REMOVE             =   8 ;
const ERR_USER_IS_NULL            =   9 ;
const ERR_USER_DATA               =  10 ;
const ERR_LOGIN_EXIST             =  11 ;
const ERR_MAIL_EXIST              =  12 ;
const ERR_PHONE_EXIST             =  13 ;
const ERR_SAVE_IMG                =  14 ;
const ERR_OWNER_IS_NULL           =  15 ;
const TYPE_WORKER                 =   1 ;
const TYPE_EMPLOYER               =   2 ;
const CAT_ALL                     =   0 ;
const CAT_COURIER                 =   1 ;
const CAT_GO_STORE                =   2 ;
const CAT_HELPER                  =   3 ;
const CAT_DRIVER                  =   4 ;
const CAT_MY_ADS                  =   5 ;
const C_MSG_ALL                   =   0 ;
const C_MSG_NEW                   =   1 ;
const C_MSG_CHAIN                 =   2 ;
const LOGIN_OK                    =   1 ;
const LOGIN_ERROR                 =   0 ;
const ADS_TYPE_EMPLOYER           =   1 ;
const ADS_TYPE_WORKER             =   2 ;
const CLLCT_CATEGORY_QT           =   5 ;
const MODE_MAIN                   =   0 ;
const MODE_DISCUS_WITH_USER       =   1 ;
const MODE_USER_ADS               =   2 ;
const MODE_TEST                   =   3 ;
const BW_STATUS_EMPTY             =   0 ;
const BW_STATUS_LIKE              =   1 ;
const BW_STATUS_BAN               =   2 ;
const ADS_VISIBLE_HIDDEN          =   0 ;
const ADS_VISIBLE_NORMAL          =   1 ;
const ADS_VISIBLE_HIDDEN_FOR_TIME =   2 ;
const ADS_VISIBLE_HIDDEN_MANUAL   =   3 ;
const ADS_VISIBLE_HIDDEN_REMOVE   =   4 ;
const NOTIFY_TYPE_CHANGE_EMAIL    =   0 ;

const MAX_LOAD_IMG_QT             =   20;
const MAX_FILE_SIZE               =   1024*1024*5;
const MAX_IMG_SIZE                =   1000;
const MAX_ICON_SIZE               =   300;

const IMG_QUALITY                 =   100;

const MSG_STATUS_NOT_DELIVER      = 0;
const MSG_STATUS_DELIVER          = 1;
const MSG_STATUS_READ             = 2;
const MSG_STATUS_UNDEFINED        = 3;

CONST EMAIL_STATUS_NOT_CONFIRM    = 0;
CONST EMAIL_STATUS_CONFIRM        = 1;

 const DATA_TYPE_NEW_USER         = 0 ;
 const DATA_TYPE_UPDATE_USER      = 1 ;
 const DATA_TYPE_UPDATE_AUTO_AUTH = 2 ;
 const DATA_TYPE_CHNG_PASSWORD    = 3 ;

const MAX_BAN_USERS_QT            = 50;
const MAX_LIKE_USERS_QT           = 50;
const MAX_ADS_QT                  = 50;





