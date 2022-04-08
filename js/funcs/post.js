function APost(data, func) {
    data.user_id   = CNTXT_.user.id;
    G_.target_act = data.act;
    $.post('/../', data, 'json')
        .success(function(data){
            try {
                q = $.parseJSON(data);
            }catch (e){
                return;
            }
            StructContext = q.context;
            AGetContext(q.context);
            func(q)
        })
        .error(function(){
            APopUpMessage('Ошибка!', ERROR);
        })
}

