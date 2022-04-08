function frmSettingPageDynamicContent(name, content) {
    data = '' +
        '<div class="content" style="margin-top: 15px; ">' +
        '   <a href="'+content+'" style="text-decoration: none; font-size: x-large; color: gray">'+name+'</a>' +
        '</div>'
    return data;
}
