function frmCategoryName(number, name) {

    data = '' +
        '<div class="val" style="margin-top: 10px" data-num="'+number+'" ' +
        '                                          data-name="'+name+'">' +
        '   <div style="width: 100%; text-align: center; font-size: xx-large">'+name+'</div>' +
        '   <div style="width: 70%; height: 2px; background-color: #9d9f9d; margin-left: 15%"></div>' +
        '</div>'
    return data;
}
