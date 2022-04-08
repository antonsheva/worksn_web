<?php
if($A_start != 444){echo 'byby';exit();}

define("OK",                       0);
define("ERROR",                   -1);
define("ERR_USER_IS_NLL",          1);
define("ERR_DB_GET_MULTIPLE_DATA", 2);
define("ERR_DB_GET_SINGLE_DATA",   3);
define("ERR_DB_CONNECT",           4);
define("ERR_DB_QUERY",             5);
define("ERR_DB_INSERT",            6);
define("ERR_DB_UPDATE",            7);

define("ERR_FILE_REMOVE",          8);

define('ERR_USER_IS_NULL',         9);
define('ERR_USER_DATA',           10);
define('ERR_LOGIN_EXIST',         11);
define('ERR_MAIL_EXIST',          12);
define('ERR_PHONE_EXIST',         13);
define('ERR_SAVE_IMG',            14);
define('ERR_OWNER_IS_NULL',       15);

define("TYPE_WORKER"  ,  1);
define("TYPE_EMPLOYER",  2);

define("CAT_ALL"       , 0);
define("CAT_COURIER"   , 1);
define("CAT_GO_STORE"  , 2);
define("CAT_HELPER"    , 3);
define("CAT_DRIVER"    , 4);
define("CAT_MY_ADS"    , 5);

define("C_MSG_ALL",    0);
define("C_MSG_NEW",    1);
define("C_MSG_CHAIN",  2);

define('LOGIN_OK',    1);
define('LOGIN_ERROR', 0);

define('ADS_TYPE_EMPLOYER', 1);
define('ADS_TYPE_WORKER',   2);

define('CLLCT_CATEGORY_QT', 5);



define('MODE_MAIN',               0);
define('MODE_DISCUS_WITH_USER',   1);
define('MODE_USER_ADS',           2);
define('MODE_TEST',               3);

define('BW_STATUS_EMPTY',  0);
define('BW_STATUS_LIKE',   1);
define('BW_STATUS_BAN',    2);

define('ADS_VISIBLE_HIDDEN', 0);
define('ADS_VISIBLE_NORMAL', 1);
define('ADS_VISIBLE_HIDDEN_FOR_TIME', 2);
define('ADS_VISIBLE_HIDDEN_MANUAL', 3);
define('ADS_VISIBLE_HIDDEN_REMOVE', 4);

define('NOTIFY_TYPE_CHANGE_EMAIL', 0);
