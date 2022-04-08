 var discusVars = {
    discus   : {},
    messages : null,
    owner    : {},
    speaker  : {},
    ads      : {},
    loadImgs : null,
    writeMsgProcessTimer : false
 }
 function resetDiscusVars() {
     $.each(discusVars, function (index, item) {
         item = null;
     })
 }