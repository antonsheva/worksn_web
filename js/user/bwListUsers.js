var bwUsersTitle = '...';
function getBanUsers() {
    bwUsersTitle = "Заблокированные пользователи";
    data = {};
    data.act = ACT_GET_BAN_USERS;
    APost(data, cbGetBwUsers);
}
function getLikeUsers() {
    bwUsersTitle = "Отмеченные пользователи";
    data = {};
    data.act = ACT_GET_LIKE_USERS;
    APost(data, cbGetBwUsers);
}


function cbGetBwUsers(data) {
    renderScreenUsersList(bwUsersTitle);
    printUsersList(CNTXT_.users_list, false, true);
}
