function frmBalloon(d) {
    var rmvBt = (d.user.id===CNTXT_.user.id) ? '<div class="balloonRmvAds">Удалить</div>' : '';
    var cost =  (d.cost !== null) ? d.cost+"p." : '';
    var body =
        rmvBt +
        '<div id="balloonDiscusCard">'+
        '   <input type="hidden" name="ads_id"   data-id = "'+d.id+'">' +
        '   <input type="hidden" name="owner_id" data-id = "'+d.user_id+'">'+
        '   <div style="height: 100%; vertical-align: top; display: inline-block;width: 20%;   padding-left: 2%">' +
                frmUserProfile(d.user, 0.06,0,1)+'<br> '+
        '   </div>' +
        '   <table style="width: 75%; display: inline-block; padding-left: 3%">' +
        '          <tr style="width: 80%">' +
        '              <td style="width: 30%" >' +
        '                   <a style="font-size: small;">'+d.create_date+'</a>' +
        '              </td>' +
        '              <td  style="width: 30%">' +
        '                   <b class="cost" style="font-size: small; float: right">'+cost+'</b>' +
        '              </td>' +
        '          </tr>' +
        '          <tr style="height: 100%">' +
        '              <td class="description" style="vertical-align: top;" colspan="2">' +
                            d.description+
        '              </td>' +
        '          </tr>' +
        '   </table> ' +
        '   <br>' +
        '   <a>.</a>'+
        '</div>';
    var content = {
        balloonContentHeader: 'cat - 1',
        balloonContent: body}
    return content;
}
