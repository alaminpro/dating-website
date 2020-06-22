var token = $('meta[name=csrf_token]').attr('content');
$(document).ready(function() { 
    var socket = io(socket_url, {
        path: '/node/socket.io',
        transports: ['polling','websocket']
    });
    var user_id = $('#main__user_id').data('id');
    var loader = $('.loader')
    var followers = $('.follow__followers');
    var following = $('.follow__following');
    var contents = $('.contents');
    var not_found = $('.not_found');
    if(!location.search){
        queryParams('?tab=followers');
    } 
    if(getQueryParams() === 'followers' || getQueryParams() === 'following'){
        var follow = getQueryParams();
        if(follow === 'followers'){
            ajax_follow('get_followers')
        }else{
            ajax_following('get_following')
        } 
    }
    if(getQueryParams() === 'followers'){
        followers.addClass('follow__tab_active');
        following.removeClass('follow__tab_active'); 
    }else{
        following.addClass('follow__tab_active'); 
        followers.removeClass('follow__tab_active') ;
    }
    followers.off('click').on('click',function(){
        $(this).addClass('follow__tab_active');
        following.removeClass('follow__tab_active'); 
        queryParams('?tab=followers')
        ajax_follow('get_followers')
        not_found.empty();
    })
    following.off('click').on('click',function(){
        $(this).addClass('follow__tab_active');
        followers.removeClass('follow__tab_active') ; 
        queryParams('?tab=following')
        ajax_following('get_following')
        not_found.empty();
    })
   
   
    function queryParams(query){
        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + query;
       return window.history.pushState({ path: newurl }, '', newurl);
    }

    function getQueryParams(){
        var queries = {};
        $.each(document.location.search.substr(1).split('&'),function(c,q){
            var i = q.split('=');
            queries[i[0].toString()] = i[1].toString();
        });
        return queries.tab
    }

    function ajax_follow(method){
      return  $.ajax({
            url: ajax_url_follow, 
            beforeSend: function(){
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div class="LoaderBalls mt-5"><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div></div>').appendTo(loader);
                contents.empty()
            },
            data: {action: method, id: logged_id, _token: token},
            dataType: 'JSON',
            type: 'POST',
            context: this,
            success: function (res) {
                if(res.status === 'success'){ 
                    if($.isEmptyObject(res.datas)){
                        $('<div class="text-center text-danger w-100"></div>').html('You have no followers at the moment').appendTo(contents);
                    }  
                    $.map(res.datas, function(data) {
                        if(data.avatar){
                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                <a href="/u/'+data.username +'" >\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="/'+ data.avatar +'" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/'+data.username +'" ><p class="follo__user_name">'+data.username+'</p></a>\
                                    <button type="button" class="follow__btn" data-id="'+ data.id +'">\
                                            <div class="btn_text">'+ data.follow +'</div>\
                                            <div class="loading"></div>\
                                        </button>\
                                </div>\
                            </div>').appendTo(contents);
                        }else{
                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                <a href="/u/'+data.username +'" >\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="assets/images/1.jpg" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/'+data.username +'" ><p class="follo__user_name">'+data.username+'</p></a>\
                                    <button type="button" class="follow__btn" data-id="'+ data.id +'">\
                                            <div class="btn_text">'+ data.follow +'</div>\
                                            <div class="loading"></div>\
                                        </button>\
                                </div>\
                            </div>').appendTo(contents);
                        }
                    }) 
                    var btn_text = $('.btn_text');
                    var loading = $('.loading');
                    $('.follow__btn').on('click', function(){
                        var id= $(this).data('id'); 
                        var btn = $(this);
                        $.ajax({
                            url: ajax_url_follow,  
                            data: {action: "follow_following", id: id, _token: token},
                            dataType: 'JSON',
                            type: 'POST',
                            context: this,
                            success: function (res) {
                                if(res.status === 'success'){  
                                    btn.html(res.data)
                                    if(res.data === 'Following'){  
                                        $.ajax({
                                            url: ajax_url_notification ,
                                            data: {action: "update_follow_notification", id: logged_id, follow_id: id, _token: token},
                                            dataType: 'JSON',
                                            type: 'POST',
                                            context: this,
                                            success: function (response) { 
                                                if(response.status === 'success'){  
                                                    socket.emit('notifications', 'status'); 
                                                }
                                            }, 
                                        });  
                                    }
                                }
                            }, 
                        });
                    })
                     /**
                     *  load more hide and show
                     * */
                    var count = [];
                    $( ".follow__content" ).each(function() {
                        count.push($( this ).data('id'));
                    }); 
                    var load = $('#load__more_main'); 
                    if(count.length >= 10){ 
                        $('<button class="custom__load_more_btn  mb-4" id="load__more"></button>').html('Load more').appendTo(load);
                    }else{
                        load.empty();
                    }
                     /**
                     *  load more 
                     * */
                    $('#load__more').on('click',function(){
                        var data_id = []
                        $( ".follow__content" ).each(function() {
                            data_id.push($( this ).data('id'));
                        }); 
                        var item = 10;
                        $.ajax({
                            url: ajax_url_follow, 
                            beforeSend: function(){
                                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div class="LoaderBalls mt-5"><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div></div>').appendTo(loader); 
                            },
                            data: {action: 'get_followers', id: logged_id, data_id: data_id, item: item, _token: token},
                            dataType: 'JSON',
                            type: 'POST',
                            context: this,
                            success: function (res) {
                                not_found.empty();
                                if(res.status === 'success'){ 
                                    if($.isEmptyObject(res.datas)){
                                        $('<div class="text-center text-danger"></div>').html('No data found!').appendTo(not_found);
                                    }  
                                    $.map(res.datas, function(data) {
                                        if(data.avatar){
                                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                                <a href="/u/'+data.username +'" >\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="/'+ data.avatar +'" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/'+data.username +'" ><p class="follo__user_name">'+data.username+'</p></a>\
                                                    <button type="button" class="follow__btn" data-id="'+ data.id +'">\
                                                            <div class="btn_text">'+ data.follow +'</div>\
                                                            <div class="loading"></div>\
                                                        </button>\
                                                </div>\
                                            </div>').appendTo(contents);
                                        }else{
                                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                                <a href="/u/'+data.username +'" >\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="assets/images/1.jpg" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/'+data.username +'" ><p class="follo__user_name">'+data.username+'</p></a>\
                                                    <button type="button" class="follow__btn" data-id="'+ data.id +'">\
                                                            <div class="btn_text">'+ data.follow +'</div>\
                                                            <div class="loading"></div>\
                                                        </button>\
                                                </div>\
                                            </div>').appendTo(contents);
                                        }
                                       
                                    }) 
                                }
                            },
                            complete: function(){
                                loader.empty();
                            }
                        });
                    })

                } 
            },
            complete: function(){
                    loader.empty();
                }
        });
    }
    function ajax_following(method){
      return  $.ajax({
            url: ajax_url_follow, 
            beforeSend: function(){
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div class="LoaderBalls mt-5"><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div></div>').appendTo(loader);
                contents.empty()
            },
            data: {action: method, id: logged_id, _token: token},
            dataType: 'JSON',
            type: 'POST',
            context: this,
            success: function (res) {
                if(res.status === 'success'){ 
                    if($.isEmptyObject(res.datas)){
                        $('<div class="text-center text-danger w-100"></div>').html('You follow no one at the moment!').appendTo(contents);
                    }  
                    $.map(res.datas, function(data) {
                        if(data.avatar){
                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                <a href="/u/'+data.username +'" >\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="'+ data.avatar +'" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/'+data.username +'" ><p class="follo__user_name">'+data.username+'</p></a>\
                                    <button type="button" class="following__btn" data-id="'+ data.id +'">\
                                            <div class="btn_text">'+ data.follow +'</div>\
                                            <div class="loading"></div>\
                                        </button>\
                                </div>\
                            </div>').appendTo(contents);
                        }else{
                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                <a href="/u/'+data.username +'" >\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="assets/images/1.jpg" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/'+data.username +'" ><p class="follo__user_name">'+data.username+'</p></a>\
                                    <button type="button" class="following__btn" data-id="'+ data.id +'">\
                                            <div class="btn_text">'+ data.follow +'</div>\
                                            <div class="loading"></div>\
                                        </button>\
                                </div>\
                            </div>').appendTo(contents);
                        }
                    }) 
                    var btn_text = $('.btn_text');
                    var loading = $('.loading');
                    $('.contents').delegate('.following__btn','click', function(){
                        var id= $(this).data('id'); 
                        var btn = $(this);
                        $.ajax({
                            url: ajax_url_follow,  
                            data: {action: "unfollowing", id: id, _token: token},
                            dataType: 'JSON',
                            type: 'POST',
                            context: this,
                            success: function (res) {
                                if(res.status === 'success'){ 
                                    btn.html(res.data)
                                    btn.closest(".col-lg-3").remove()
                                }
                            }, 
                        });
                    })
                     /**
                     *  load more hide and show
                     * */
                    var count = [];
                    $( ".follow__content" ).each(function() {
                        count.push($( this ).data('id'));
                    }); 
                    var load = $('#load__more_main'); 
                    if(count.length >= 10){ 
                        $('<button class="custom__load_more_btn  mb-4" id="load__more"></button>').html('Load more').appendTo(load);
                    }else{
                        load.empty();
                    }
                     /**
                     *  load more 
                     * */
                    $('#load__more').on('click',function(){
                        var data_id = []
                        $( ".follow__content" ).each(function() {
                            data_id.push($( this ).data('id'));
                        }); 
                        var item = 10;
                        $.ajax({
                            url: ajax_url_follow, 
                            beforeSend: function(){
                                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div class="LoaderBalls mt-5"><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div></div>').appendTo(loader); 
                            },
                            data: {action: 'get_following', id: logged_id, data_id: data_id, item: item, _token: token},
                            dataType: 'JSON',
                            type: 'POST',
                            context: this,
                            success: function (res) {
                                not_found.empty();
                                if(res.status === 'success'){ 
                                    if($.isEmptyObject(res.datas)){
                                        $('<div class="text-center text-danger"></div>').html('Thats it!').appendTo(not_found);
                                    }  
                                    $.map(res.datas, function(data) {
                                        if(data.avatar){
                                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                                <a href="/u/'+data.username +'" >\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="/'+ data.avatar +'" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/'+data.username +'" ><p class="follo__user_name">'+data.username+'</p></a>\
                                                    <button type="button" class="following__btn" data-id="'+ data.id +'">\
                                                            <div class="btn_text">'+ data.follow +'</div>\
                                                            <div class="loading"></div>\
                                                        </button>\
                                                </div>\
                                            </div>').appendTo(contents);
                                        }else{
                                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                                <a href="/u/'+data.username +'" >\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="assets/images/1.jpg" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/'+data.username +'" ><p class="follo__user_name">'+data.username+'</p></a>\
                                                    <button type="button" class="following__btn" data-id="'+ data.id +'">\
                                                            <div class="btn_text">'+ data.follow +'</div>\
                                                            <div class="loading"></div>\
                                                        </button>\
                                                </div>\
                                            </div>').appendTo(contents);
                                        }
                                    }) 
                                }
                            },
                            complete: function(){
                                loader.empty();
                            }
                        });
                    })

                } 
            },
            complete: function(){
                    loader.empty();
                }
        });
    }
    
    function setCookie(name, value, maxAgeSeconds) {
        var maxAgeSegment = "; max-age=" + maxAgeSeconds;
        document.cookie = encodeURI(name) + "=" + encodeURI(value) + maxAgeSegment;
    }
//    $('#status__input').on('keypress',function(e){
//         if(e.which === 13){
//             var value = $(e.currentTarget).val(); 
//             $.ajax({
//                 url: ajax_url_follow,  
//                 data: {action: "updateStatus", id: user_id, status: value, _token: token},
//                 dataType: 'JSON',
//                 type: 'POST',
//                 context: this,
//                 success: function (res) {
//                     if(res.status === 'success'){ 
//                         socket.emit('notifications', res.user.username); 
//                         $('#status__input').val('');  
//                         setCookie("update-status", "status", 5);
//                         window.location.href = '/u/'+ res.user.username; 
//                     }
//                 }, 
//             });
//         }
//    })
    $('.status__btn').on('click',function(e){ 
            var value = $('#status__input').val(); 
            $.ajax({
                url: ajax_url_follow,  
                data: {action: "updateStatus", id: user_id, status: value, _token: token},
                dataType: 'JSON',
                type: 'POST',
                context: this,
                success: function (res) {
                    if(res.status === 'success'){ 
                        $.ajax({
                            url: ajax_url_notification,  
                            data: {action: "update_status_notification", id: user_id, message: res.user.user_status, _token: token},
                            dataType: 'JSON',
                            type: 'POST',
                            context: this,
                            success: function (response) { 
                                if(response.status === 'success'){  
                                    socket.emit('notifications', 'status');  
                                    setTimeout(() => {
                                        $('#status__input').val('');  
                                        setCookie("update-status", "status", 5);
                                        window.location.href = '/u/'+ res.user.username; 
                                    }, 500);
                                }
                            }, 
                        }); 
                       
                    }
                }, 
            }); 
        })
}); 