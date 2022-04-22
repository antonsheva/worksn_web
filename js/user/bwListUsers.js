var bwListUsersTitle = '...';
function getBanUsers() {
    bwListUsersTitle = STRING_BAN_USERS;
    data = {};
    data.act = ACT_GET_BAN_USERS;
    APost(data, cbGetBwUsers);
}
function getLikeUsers() {
    bwListUsersTitle = STRING_CHOOSE_USERS;
    data = {};
    data.act = ACT_GET_LIKE_USERS;
    APost(data, cbGetBwUsers);
}
function cbGetBwUsers(data) {
    renderScreenUsersList(bwListUsersTitle);
    printUsersList(CNTXT_.users_list, false, true);
}
