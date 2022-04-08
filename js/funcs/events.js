function fixEventData(obj, e, type) {
    G_event.timer = C_ENABLE;
    G_event.click = C_ENABLE;
    if(type ==='touchstart'){
        var touch = e.originalEvent.touches[0];
        topShift = parseInt( $(obj).css('height'));
        G_mouseY = parseInt($(obj).offset().top);
        if(G_mouseY > 80) G_mouseY = G_mouseY-70;
        G_mouseX = touch.clientX;
        G_mouseX = parseInt(G_mouseX)
    }else{
        G_mouseX = e.clientX;
        topShift = parseInt( $(obj).css('height'));
        G_mouseY = parseInt($(obj).offset().top);
    }

}
var pressButton_obj = null;
var pressButton_color = null;

function pressButtonAnime(obj, color) {
    pressButton_obj = obj;
    pressButton_color = $(obj).css('background-color')
    $(obj).css('background-color', color)
    tmpTimer = setTimeout(function () {
        $(pressButton_obj).css('background-color', pressButton_color)
    }, 150);
}
