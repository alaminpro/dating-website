require('./bootstrap'); 
require('jquery-ui');
require('jquery-slimscroll');
 

 
$(function(){
    var token = $('meta[name=csrf_token]').attr('content'); 
    var socket = io(socket_url, {
        path: '/node/socket.io',
        transports: ['polling','websocket']
    });


    $('.sidebar__main').slimScroll({
		height: '90vh'
	});
    $('.notification__data .notification__ul_nav').slimScroll({
		height: '400px'
    });
   
    
    $('.datev2__trands .notification__ul').slimScroll({
		height: '150px'
	});
    $('.datev2__follow .notification__ul').slimScroll({
		height: '150px'
	});
    $('.sidebar__hide_icon i').click(function () {
        $(".sidebar").toggleClass("toggle__sidebar");  
        $(".main").toggleClass("toggle__main");  
    });

    $('body').click(function(e){
        if ($(e.target).closest('.dropdown-menu').length === 0) {
            $('.notification_main .dropdown-menu').removeClass('is-active') 
        } 
        if ($(e.target).closest('.notify__popup').length === 0) {
            $('.notify__popup').removeClass('active') 
        } 
    });

     // start coding for notifications   
    notification__count()
    socket.on('notifications', function(){
        notification__count()
        latest_single_notification()
    }); 

    $("#notification").click(function(e){ 
        e.stopPropagation(); 
        $('.notification_main .dropdown-menu').toggleClass('is-active')

        var alreadyClicked = $(this).hasClass('clicked');
        
        if(!alreadyClicked){
            ajax_notifications()
        }

        $(this).addClass('clicked'); 
    });
    
    function ajax_notifications(){
        var loader = $('.notification__loader');
        var contents = $('.notification__ul_nav');
        return  $.ajax({
            url: ajax_url_notification, 
            beforeSend: function(){
                contents.empty()
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div id="loader"></div>').appendTo(loader);  
            },
            data: {action: 'get_latest_notification', _token: token},
            dataType: 'JSON',
            type: 'POST',
            context: this,
            success: function (res) {
                if(res.status === 'success'){  
                    if($.isEmptyObject(res.datas.today) && $.isEmptyObject(res.datas.earlier)){
                        $('<div class="text-center text-danger w-100 my-5"></div>').html('Notification not found!').appendTo(contents); 
                    }    
                    contents.append(res.html);
                    delete__notification() ;
                    markas__read_unread();
                    notification_view();
                } 
            },
            complete: function(){
                loader.empty();
            }
        });
    }
    load_notifications()
    function load_notifications(){
        var loader = $('.notifications__page_loader');
        var contents = $('.notification__page_ul_nav');
        return  $.ajax({
            url: ajax_url_notification, 
            beforeSend: function(){
                contents.empty()
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div id="loader"></div>').appendTo(loader);  
            },
            data: {action: 'get_all_notification', _token: token},
            dataType: 'JSON',
            type: 'POST',
            context: this,
            success: function (res) {
                if(res.status === 'success'){  
                    if($.isEmptyObject(res.datas) ){
                        $('<div class="text-center text-danger w-100 my-5"></div>').html('Notification not found!').appendTo(contents); 
                    }    
                    contents.append(res.html);
                    delete__notification() ;
                    markas__read_unread();
                     notification_view();
                } 
            },
            complete: function(){
                loader.empty();
            }
        });
    }

    /*
    * coding for notification delete 
    */
    function delete__notification(){
        $(".notify__option").click(function(e){
            e.stopPropagation(); 
             $('.notify__popup').removeClass('active')
             $('.notification__ul li').removeClass('hover__active')
            $(this).find('.notify__popup').toggleClass('active') 
            $(this).closest('li').addClass('hover__active')
        });

        $('.notify__icon').click(function(){
            var id = $(this).data('id'); 
            if(confirm('Are you sure!')){
                $.ajax({
                    url: ajax_url_notification,
                    data: {action: 'delete__notification', id: id, _token: token},
                    dataType: 'JSON',
                    type: 'POST',
                    context: this,
                    success: function (res) {
                        if(res.status === 'success'){
                            $.toast({
                                heading: 'Warning',
                                text: 'Deleted Success', 
                                icon: 'warning',
                                position: 'bottom-right',
                            })
                            $(this).closest('li').remove();
                            notification__count()
                        } 
                    }
                })
            }
        })
    }
    function markas__read_unread(){ 
        var mark_option = $('.mark__as_option');
        mark_option.on('click', function(){ 
            var id = $(this).data('id');
            var data =$(this).children().data('read')  
            $.ajax({
                url: ajax_url_notification,
                data: {action: 'markas__read', id: id, data:data, _token: token},
                dataType: 'JSON',
                type: 'POST',
                context: this,
                success: function (res) {
                    if(res.status === 'success'){
                        $(this).empty();  
                        $('.all__markasread').removeClass('readed');
                        notification__count();  
                        if(res.data.read === 0){  
                            $(this).closest('li').addClass('notification__active');
                            $('<span tooltip="Mark as read" flow="left" data-read="1"></span>').html('<i class="far fa-envelope"></i>').appendTo($(this));
                        }else{  
                            $(this).closest('li').removeClass('notification__active');
                            $('<span tooltip="Mark as unread" flow="left" data-read="0"></span>').html('<i class="far fa-envelope-open"></i>').appendTo($(this));
                        } 
                    } 
                }
            })
        })
    }
    all__markasread();
    function all__markasread(){ 
        var all__markasread = $('.all__markasread'); 
        all__markasread.on('click', function(){  
            var alreadyClicked = $(this).hasClass('readed');
            if(!alreadyClicked){
                $.ajax({
                    url: ajax_url_notification,
                    data: {action: 'all__markasread', _token: token},
                    dataType: 'JSON',
                    type: 'POST',
                    context: this,
                    success: function (res) {
                        if(res.status === 'success'){
                            $('.mark__as_option').empty();  
                            notification__count();   
                            $('.notification__ul_nav .notification__ul li').removeClass('notification__active');
                            $('<span tooltip="Mark as unread" flow="left" data-read="0"></span>').html('<i class="far fa-envelope-open"></i>').appendTo($('.mark__as_option'));
                        
                        } 
                    }
                })
            }
            $(this).addClass('readed'); 
        }) 
        
    }
   
    /**
     * start coding for notification count
     */
    function latest_single_notification(){
        $.ajax({
            url: ajax_url_notification,
            data: {action: 'latest_single_notification', _token: token},
            dataType: 'JSON',
            type: 'POST',
            success: function (res) {
                if(res.status === 'success'){
                    $('.notification__todays').prepend(res.html)
                    markas__read_unread()
                } 
            }
        })
    }
    /**
     * start coding for notification count
     */
    function notification__count(){ 
        $.ajax({
            url: ajax_url_notification,
            data: {action: 'notification_count', _token: token},
            dataType: 'JSON',
            type: 'POST',
            success: function (res) {
                if(res.status === 'success'){
                    $('.notification').removeClass('clicked');
                    if(res.data != 0){
                        $('#update__badge').html(res.data)
                    } else{
                        $('#update__badge').empty()
                    }
                } 
            }
        })
    }
    /**
     * start coding for notification count
     */
  
    function notification_view(){
        var notification__link = $('.notification__link');
        notification__link.click(function(){
            var id = $(this).data('id');
            $.ajax({
                url: ajax_url_notification,
                data: {action: 'notification_view', id:id, _token: token},
                dataType: 'JSON',
                type: 'POST',
                success: function (res) {
                    if(res.status === 'success'){
                        window.location = res.url.redirect_url;
                    } 
                }
            })
        })
       
    }
    /**
     * start coding for Who to follow
     */
    // who__to_follow();
    function who__to_follow(){
        var contents = $('.who__to_follow');
        var loader = $('.follow__page_loader');
        $.ajax({
            url: ajax_url_notification, 
            beforeSend: function(){
                contents.empty()
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div id="loader"></div>').appendTo(loader);  
            },
            data: {action: 'who_to_follow', _token: token},
            dataType: 'JSON',
            type: 'POST',
            context: this,
            success: function (res) {
                if(res.status === 'success'){  
                    if($.isEmptyObject(res.datas) ){
                        $('<div class="text-center text-danger w-100 my-5"></div>').html('data not found!').appendTo(contents); 
                    }    
                    contents.append(res.html); 
                } 
            },
            complete: function(){
                loader.empty();
            }
        }); 
    }

    /**
     * start coding for search functionality 
     */
    main__search();
    function main__search(){
        var content = $('.main-content');
        var search_item = $('.main__search_item');
        var search = $('.datev2__search_input');
        var loader = $('.main-content_loader');
        var main_contents = $('.main-contents');
        var val = search.val();
        if(val){
            search_item.css('display','block');
            content.css('display','none');
            main_contents.css('display','none');
            ajax__search(val, loader, search_item);
        }else{
            content.css('display','block');
            main_contents.css('display','block');
            search_item.css('display','none');
        }
        search.on('keyup',function(){
            var value = $(this).val();
            loader.empty()
            search_item.empty()
            if(value){
                content.css('display','none');
                main_contents.css('display','none');
                search_item.css('display','block');
                ajax__search(value, loader, search_item);
            }else{
                main_contents.css('display','block');
                content.css('display','block');
                search_item.css('display','none');
            }
        })


       function ajax__search(value, loader, search_item){
            $.ajax({
                url: ajax_url_notification, 
                beforeSend: function(){ 
                    search_item.empty();
                    $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div id="loader"></div>').appendTo(loader);  
                },
                data: {action: 'main__search', keyword: value, _token: token},
                dataType: 'JSON',
                type: 'POST',
                context: this,
                success: function (res) {
                    if(res.status === 'success'){  
                        if($.isEmptyObject(res.datas) ){
                            $('<div class="text-center text-danger w-100 py-5"></div>').html('Result not found!').appendTo(search_item); 
                        }     
                        $('<div class="row m-0"></div>').html(res.html).appendTo(search_item);  
                    }
                },
                complete: function(){
                    loader.empty();
                }
        }); 
       }
    }
}); 