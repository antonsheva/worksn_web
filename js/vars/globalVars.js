var G_tmp_img = null;
var G_ads_timer = null;
var G_ev_balloonopen = null;
var G_objCounter = 0;
var G_globalMode = 0;
var G_imgType = null;
var G_tmpImgState = 0;
var G_mouseX = 0, G_mouseY = 0;
var myMap;
var G_ = {
    discus :{
        id              : null,
        sender_id       : null,
        consumer_id     : null,
        ads_id          : null,
        content         : null
    },
    user:{
        id          : null,
        login       : null,
        password    : null,
        cookie_pass : null,
        auto_auth   : null,
        name        : null,
        s_name      : null,
        phone       : null,
        email       : null,
        send_mail   : null,
        img         : null,
        city_id     : null,
        region_id   : null,
        create_date : null,
        last_time   : null,
        rating      : null,
        rights      : null,
        vote_qt     : null,
        about_user  : null,
        web_site    : null,
        ws_token    : null
    },
    owner:{
        id          : null,
        login       : null,
        password    : null,
        cookie_pass : null,
        auto_auth   : null,
        name        : null,
        s_name      : null,
        phone       : null,
        email       : null,
        send_mail   : null,
        img         : null,
        city_id     : null,
        region_id   : null,
        create_date : null,
        last_time   : null,
        rating      : null,
        rights      : null,
        vote_qt     : null,
        about_user  : null,
        web_site    : null,
        status      : null
    },
    review:{
        id          : null,
        sender_id   : null,
        consumer_id : null,
        star_qt     : null,
        favorite    : null,
        comment     : null,
        create_date : null
    },
    msg:{
        id                 : null,
        sender_id          : null,
        sender_login       : null,
        sender_rating      : null,
        sender_img         : null,
        consumer_id        : null,
        consumer_login     : null,
        consumer_rating    : null,
        consumer_img       : null,
        content            : null,
        img                : null,
        cost               : null,
        view               : null,
        create_date        : null,
        discus_id          : null,
        ads_id             : null,
        ads_description    : null,
        ads_type           : null
    },
    target_ads:{
        id          : null,
        ads_type    : null,
        user_id     : null,
        user_login  : null,
        user_rating : null,
        category    : null,
        active      : null,
        coord_x     : null,
        coord_y     : null,
        img         : null,
        description : null,
        cost        : null,
        crete_date  : null,
        min_x       : null,
        max_x       : null,
        min_y       : null,
        max_y       : null
    },
    discus_card:{
        img:null,
        login:null,
        rating:null,
        descFull:null,
        descCut:null,
        cost:null,
        discus_id:null

    },
    user_reviews    : {},
    sub_data        : {},
    discus_id       : null,
    msg_id          : null,
    page_name       : null,
    ads_type        : null,
    ads_category    : null,
    ads_collection  : {},
    ads_owner_id    : null,
    ads_owner_login : null,
    messages        : null,
    cnt             : 0,
    img_cnt         : 0,
    img_panel_cnt   : 0,
    load_img_cnt    : 0,
    target_id       : null,
    target_act      : null
};
