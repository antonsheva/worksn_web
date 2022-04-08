function renderEnvironmentData(data) {
    createCatLists(data.categories);
    createLifetimesList(data.lifetime);
}


function createCatLists(d) {
    $('#frmCategory').empty();

    $.each(d, function (index, item) {
        data = frmCategoryName(item.val, item.name);
        $('#frmCategory').append(data);
    })
}
function createLifetimesList(d) {
    $('#frmLifetime').empty();
    $.each(d, function (index, item) {

        data = frmLifetime(item.val, item.name);
        $('#frmLifetime').append(data);
    });
}
function createSettingPageDynamicContent(data) {
    $('#settingPageContent').empty();
    $.each(data, function (index, d) {
        data = frmSettingPageDynamicContent(d.name, d.description);
        $('#settingPageContent').append(data);
    });
}