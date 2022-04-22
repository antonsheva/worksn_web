var ADD_ADS_ERR_TIME_RANGE = 1;

var ADS_VISIBLE_HIDDEN          = 0;
var ADS_VISIBLE_NORMAL          = 1;
var ADS_VISIBLE_HIDDEN_FOR_TIME = 2;
var ADS_VISIBLE_HIDDEN_MANUAL   = 3;
var ADS_VISIBLE_HIDDEN_REMOVE   = 4;


var adsVars = {
    targetAds   : {},
    adsCllct    : null,
    lifetime    : null,
    error       : null,

    hourStart : null,
    hourStop  : null,
    minStart  : null,
    minStop   : null,
    adsList   : [],

    editFlag   : false,
    oldImgs    : null,
    oldImgsIcon: null
};
var CLLCT_ = {
    ads_type  : null,
    category  : null,
    user_id   : null,
    remove    : 0,
    active    : 1
};

