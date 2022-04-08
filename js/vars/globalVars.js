var G_tmp_img = null;

// ----- collection style  ---------------
const C_RED     =    1;
const C_BLUE    =    2;
const C_GREEN   =    3;
const C_YELLOW  =    4;
const C_VIOLET  =    5;
//----------------------------------------

const C_TYPE_ANY       = 0;
const C_TYPE_EMPLOYER  = 1;
const C_TYPE_WORKER    = 2;


const ERROR = -1;
const OK    =  0;


//------- MAPS ---------------------


var G_ads_timer = null;
var G_ev_balloonopen = null;



var myMap = null;
var myMapCollectionRed  = null;
var myMapCollectionBlue  = null;


//------------------------------

var G_notify = 0;
var G_lifetime = 0;


//---- Ads categorys -----------
const C_COURIER       = 1;
const C_STORE_RUNNER  = 2;
const C_HOME_WORKER   = 3;
const C_CAR_DRIVER    = 4;
//------------------------------

const ON  = 1;
const OFF = 0;

const C_OPEN   = 1;
const C_CLOSED = 0;

const C_WEB_BROWSER = 1;
const C_ANDROID     = 2;


var G_objCounter = 0;




var G_msgFiledState = 0;


const C_MAIN_MSG       = 0;
const C_MAIN_ADD_ADS   = 1;
const C_DISCUS         = 2;

var G_screenState = C_MAIN_MSG;

//------------------------------

//-------- MSG SCREEN ----------
const C_SCREEN_MSG         = 0;
const C_SCREEN_CATEGORY    = 1;
const C_SCREEN_USERS       = 2;
const C_SCREEN_ADD_ADS     = 3;
const C_SCREEN_LIFETIME    = 4;
const C_SCREEN_SEARCH      = 5;
const C_SCREEN_VISIBLE_ADS = 6;
//------------------------------

const C_FOOTER_SEARCH     = 0;
const C_FOOTER_DISCUS     = 1;

const C_MODE_MAIN     = 0;
const C_MODE_ADD_ADS  = 1;
const C_MODE_UPDT_ADS = 2;



const C_IMG_HIDDEN = 0;
const C_IMG_SUBMIT = 1;
const C_IMG_ZOOM   = 2;
const C_IMG_AVATAR = 0;
const C_IMG_MSG    = 1;
const C_IMG_ADS    = 2;

const C_ENABLE  = 0;
const C_DESABLE = 1;


var G_discusCardBig = false;
var G_returnDirection = null;
var G_globalMode = C_MODE_MAIN;
var G_imgType = null;
var G_tmpImgState = 0;
var G_mouseX = 0, G_mouseY = 0;

var G_footer_type = C_FOOTER_SEARCH;

