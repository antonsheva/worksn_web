function MapInit () {
    // var descript, cat;
    var myPlacemark;

    myMap = new ymaps.Map("map", {
        center: [mapVars.center_x, mapVars.center_y], // Углич
        zoom: mapVars.zoom

    }, {
        balloonMaxHeight: 150,
        balloonCloseButton : false,
        searchControlProvider: 'yandex#search'
    });

    objectManagerBlue = new ymaps.ObjectManager({
        clusterize: true,
        gridSize: 64,
        clusterDisableClickZoom: true,
        clusterBalloonMaxWidth: 550,
        clusterBalloonMaxHeight: 300
    });
    objectManagerGreen = new ymaps.ObjectManager({
        clusterize: true,
        gridSize: 64,
        clusterDisableClickZoom: true,

        clusterBalloonMaxWidth: 550,
        clusterBalloonMaxHeight: 300
    });
    objectManagerYellow = new ymaps.ObjectManager({
        clusterize: true,
        gridSize: 64,
        clusterDisableClickZoom: true,
        clusterBalloonMaxWidth: 550,
        clusterBalloonMaxHeight: 300
    });
    objectManagerViolet = new ymaps.ObjectManager({
        clusterize: true,
        gridSize: 64,
        clusterDisableClickZoom: true,
    });

    objectManagerViolet.objects.options.set('preset', 'islands#redIcon')
    objectManagerViolet.clusters.options.set('preset', 'islands#blueClusterIcons');

    objectManagerBlue.objects.options.set('preset', 'islands#blueDotIcon');
    objectManagerBlue.clusters.options.set('preset', 'islands#blueClusterIcons');

    objectManagerGreen.objects.options.set('preset', 'islands#darkGreenDotIcon');
    objectManagerGreen.clusters.options.set('preset', 'islands#darkGreenClusterIcons');

    objectManagerYellow.objects.options.set('preset', 'islands#yellowDotIcon');
    objectManagerYellow.clusters.options.set('preset', 'islands#yellowClusterIcons');


    myMapCollectionViolet = new ymaps.GeoObjectCollection({}, {
        preset: "islands#violetIcon"
    });
    myMapCollectionRed = new ymaps.GeoObjectCollection({}, {
        preset: "islands#redIcon"

    });
    myMapCollectionBlue = new ymaps.GeoObjectCollection({}, {
        preset: "islands#blueIcon"
    });
    myMapCollectionGreen = new ymaps.GeoObjectCollection({}, {
        preset: "islands#darkGreenIcon"
    });
    myMapCollectionYellow = new ymaps.GeoObjectCollection({}, {
        preset: "islands#yellowIcon",
        balloonMaxHeight: 150
    });
    myMap.geoObjects.add(myMapCollectionRed);
    myMap.geoObjects.add(myMapCollectionBlue);
    myMap.geoObjects.add(myMapCollectionGreen);
    myMap.geoObjects.add(myMapCollectionYellow);
    myMap.geoObjects.add(myMapCollectionViolet);

    myMap.geoObjects.events.add('click', function (e) {
        myMap.balloon.close();
    })

    myMap.geoObjects.add(objectManagerBlue);
    myMap.geoObjects.add(objectManagerGreen);
    myMap.geoObjects.add(objectManagerYellow);
    myMap.geoObjects.add(objectManagerViolet);

    myMap.events.add('boundschange', function (e) {
        if (mapVars.noBoundsChange){
            mapVars.noBoundsChange = false;
            return;
        }
        getMapCenter();
        getZoom();
        AGetMapArea();
        AReloadAdsCollection();
    });
    myMap.events.add('balloonopen', function (e) {
        G_ev_balloonopen = 1;                                                 // Off reload ads when open balloon
        mapVars.noBoundsChange = true;
        var id = GP('balloonDiscusCard').consumer_id;
        wsSendGetOnlineStatus(id);
        AClrPlasemarks(C_VIOLET);
    });




    myMap.events.add('click', function (e) {
        clearTmpPoints();
        mapVars.targetCoords = null;
        if(G_globalMode === C_MODE_ADD_ADS){
            mapVars.targetCoords = e.get('coords');
            myPlacemark = new ymaps.Placemark(mapVars.targetCoords);
            AClrPlasemarks(C_RED);
            AAddPlacemarkToCollection(myPlacemark, C_RED);
        }
    });
    $('#map').on('click', '.ymaps-2-1-78-b-cluster-tabs__menu-item', function () {
        var id = $("#balloonDiscusCard .consumer_id").val();
        AClrPlasemarks(C_VIOLET);
        wsSendGetOnlineStatus(id);
    })
    $('#onClick').on('click', function (event, ui) {
        myMap.container.fitToViewport();
        AClrPlasemarks(C_VIOLET);
    });
/////////////////////////////////////////////////////////////////////////////////////////////
    AGetMapArea();
    AGetAdsCollection();


}

function AGetMapArea() {
    var map_area = myMap.getBounds();
    MIN_MAX_CRD_.min_x = map_area[0][0];
    MIN_MAX_CRD_.max_x = map_area[1][0];
    MIN_MAX_CRD_.min_y = map_area[0][1];
    MIN_MAX_CRD_.max_y = map_area[1][1];
}
function getMapCenter() {
    var center = myMap.getCenter();
    mapVars.center_x = center[0];
    mapVars.center_y = center[1];
}
function getZoom() {
    mapVars.zoom = myMap.getZoom();
}
function AAddPlacemarkToCollection(pm, collection){
    if(!collection)collection = C_RED;
    switch (collection){
        case C_RED   : myMapCollectionRed. add(pm); break;
        case C_BLUE  : objectManagerBlue.  add(pm); break;
        case C_GREEN : objectManagerGreen. add(pm); break;
        case C_YELLOW: objectManagerYellow.add(pm); break;
        case C_VIOLET: myMapCollectionViolet.add(pm); break;
    }
}
function AShowPlaceMark(data) {
    var user = {};
    user.id     = data.user_id;
    user.login  = data.user_login;
    user.rating = data.user_rating;
    user.img_icon = data.user_img_icon;
    data.user = user;
    var lat = data.coord_x;
    var lon = data.coord_y;
    var balloon_content = frmBalloon(data);
    var pm = {
        type:       'Feature',
        id:         data.id,
        geometry  : {"type": "Point", "coordinates": [lat, lon]},
        properties: balloon_content,
    };
    if(data.user.id == CNTXT_.user.id)tp = C_YELLOW;
    else{
        if(data.ads_type == 1)tp = C_BLUE;
        else                  tp = C_GREEN;
    }
    AAddPlacemarkToCollection(pm,tp);
}
function AClrPlasemarks(type) {
    switch (type){
        case C_GREEN   : objectManagerGreen.removeAll(); break;
        case C_BLUE    : objectManagerBlue.removeAll();  break;
        case C_YELLOW  : objectManagerYellow.removeAll();break;
        case C_VIOLET  : objectManagerViolet.removeAll();
                         myMapCollectionViolet.removeAll(); break;
        case C_RED     : myMapCollectionRed.removeAll(); break;
        default :
            objectManagerGreen.removeAll();
            objectManagerBlue.removeAll();
            objectManagerYellow.removeAll();
            objectManagerViolet.removeAll();

            myMapCollectionGreen.removeAll();
            myMapCollectionBlue.removeAll();
            myMapCollectionYellow.removeAll();
            myMapCollectionViolet.removeAll();

    }

}
function setCenterToMyLocation(setPoint) {
    navigator.geolocation.getCurrentPosition(function (position) {

        clearTmpPoints();

        coords = position.coords;
        mapVars.center_x = coords.latitude;
        mapVars.center_y = coords.longitude;
        mapVars.coords[0] = coords.latitude;
        mapVars.coords[1] = coords.longitude;
        mapVars.zoom = myMap.getZoom();
        myMap.setCenter(mapVars.coords, mapVars.zoom);

        if(setPoint){
            mapVars.targetCoords = mapVars.coords;
            myMapSetRedPoint(mapVars.targetCoords);
        }
    })
}
function clearTmpPoints() {
    myMapCollectionRed.removeAll();
    myMapCollectionViolet.removeAll();
    myMap.balloon.close();
}
function setMapCenter(center) {
    mapVars.center_x = center[0];
    mapVars.center_y = center[1];
    myMap.setCenter(center, mapVars.zoom);
}

function myMapSetRedPoint(coords) {
    var myPm = new ymaps.Placemark(coords);
    mapVars.noBoundsChange = true;
    setMapCenter(mapVars.coords);
    AAddPlacemarkToCollection(myPm, C_RED);
}



