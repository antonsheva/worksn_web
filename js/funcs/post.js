function APost(data, func) {
    data.user_id   = CNTXT_.user.id;
    G_.target_act = data.act;
    console.log(data)
    $.post('/../', data, 'json')
        .success(function(data){
            try {
                q = $.parseJSON(data);
                console.log(q)

            }catch (e){
                return;
            }
            StructContext = q.context;
            AGetContext(q.context);
            func(q)
        })
        .error(function(){
            APopUpMessage(STRING_ERROR, ERROR);
        })
}

