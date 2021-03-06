require('./bootstrap'); 
require('jquery-ui');
require('jquery-slimscroll');
require('jquery-datetimepicker');
 

 
$(function(){
    var token = $('meta[name=csrf_token]').attr('content'); 
    if(logged_id){
        var socket = io(socket_url, {
            path: '/node/socket.io',
            transports: ['polling','websocket']
        });
    }


    $('.sidebar__main').slimScroll({
		height: '90vh'
	});
    $('.feature__modal_scrool').slimScroll({
		height: '400px'
	});
    $('.notification__data .notification__ul_nav').slimScroll({
		height: '400px'
    });
    $('.feature__ul li').hover(function(){
        $(this).tooltip('toggle')
    })

    
    $('.datev2__trands .notification__ul').slimScroll({
		height: '150px'
	});
    $('.datev2__follow .notification__ul').slimScroll({
		height: '150px'
	});
    $('.sidebar__hide_icon i').click(function () {
        $(".sidebar").toggleClass("toggle__sidebar");  
        $(".main").toggleClass("toggle__main");  
        $('.right__sidebar').removeClass('right__sidebar_active')
        $(".main").removeClass("toggle__main_right");  
    });

    $('body').click(function(e){
        if ($(e.target).closest('.dropdown-menu').length === 0) {
            $('.notification_main .dropdown-menu').removeClass('is-active') 
        } 
        if ($(e.target).closest('.notify__popup').length === 0) {
            $('.notify__popup').removeClass('active') 
        } 
    });
    $('.search__icon i').click(function(){
        $('.datev2__ul').addClass('search__active')
        $('.datev2__search_main').addClass('search__main_active') 
    })
    $('.search__cencel_area i').click(function(){
        $('.datev2__ul').removeClass('search__active')
        $('.datev2__search_main').removeClass('search__main_active') 
        $('.datev2__search_input').val('');
        var content = $('.main-content');
        var search_item = $('.main__search_item'); 
        var main_contents = $('.main-contents');  
        content.css('display','block');
        main_contents.css('display','block');
        search_item.css('display','none');
    })

    $('.right__sidebar_toggle i').click(function(){
        $('.right__sidebar').toggleClass('right__sidebar_active')
        $(".main").toggleClass("toggle__main_right");  
        $(".sidebar").removeClass("toggle__sidebar");  
        $(".main").removeClass("toggle__main");  
    })
     // start coding for notifications   
  
    if(logged_id){
        notification__count()
        socket.on('notifications', function(){
            notification__count()
            latest_single_notification()
        }); 
    }
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
    if(logged_id){
        load_notifications()
    }
   
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
    if(logged_id){
        all__markasread();
    }

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
                    delete__notification() ;
                    markas__read_unread();
                    notification_view();
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
            $('.datev2__ul').addClass('search__active')
            $('.datev2__search_main').addClass('search__main_active') 
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
    /**
     * start coding for users featrue area
     */
    if(logged_id){
        
    $('.feature__auth_li').on('click',function(){ 
        $('.modal__free_premium_body').empty(); 
        $.ajax({
            url: ajax_url,  
            data: {action: 'check_feature_free_premium', _token: token},
            dataType: 'JSON',
            type: 'POST',
            context: this,
            success: function (res) {  
                if(res.status === 'success'){ 
                   let dialog = $('#modal__free_premium .modal-dialog');   
                    if(res.is_featured == 1){ 
                        if (res.coins < res.min_coin) {
                            if(dialog.hasClass('modal-lg')){
                                dialog.removeClass('modal-lg')
                                dialog.addClass('modal-sm')
                            }   
                        }else{
                            if(dialog.hasClass('modal-sm')){
                                dialog.removeClass('modal-sm')
                                dialog.addClass('modal-lg')
                            }
                        }
                    }else{
                        if(dialog.hasClass('modal-lg')){
                            dialog.removeClass('modal-lg')
                            dialog.addClass('modal-sm')
                        }
                    }
                    $('.modal__free_premium_body').empty();  
                    $('.modal__free_premium_body').append(res.html);    
                    $('#modal__free_premium').modal('show');
                    premium__features(res.coins);
                    premium__features_btn();
                } 
            }, 
        });
       
    })


    const premium__features = (coin) => {
        $('.premium__area').click(function(){
            let current_coin = $(this).attr('data-coin');
            if(coin >= current_coin){
                $('.premium__area').removeClass('select__feature')
                $(this).addClass('select__feature')
                $('.free__premium_btn').attr('data-coin', $(this).attr('data-coin')) 
            } else{ 
                $.toast({
                    heading: 'Warning',
                    text: 'Opps! you don\'t have enough coins for this plan.', 
                    icon: 'warning', 
                    bgColor : '#E01A31',
                    position: 'top-right',
                })
            }
        })
    }
    const premium__features_btn = () => {
        $('.free__premium_btn').click(function(){ 
            let coin = $(this).attr('data-coin');
            if(coin){
                console.log(coin)
            }else{
                $.toast({
                    heading: 'Warning',
                    text: 'Please select at least on plan!', 
                    icon: 'warning', 
                    bgColor : '#E01A31',
                    position: 'top-right',
                }) 
            }
        })
    }



 
    const get__feature_ajax = () => { 
        let loader = $('.feature__search_loader');
        let contents = $('.feature__content');
        return  $.ajax({
            url: ajax_url, 
            beforeSend: function(){
                contents.empty()
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div id="loader"></div>').appendTo(loader);  
            },
            data: {action: 'get__feature', _token: token},
            dataType: 'JSON',
            type: 'POST',
            context: this,
            success: function (res) {
                if(res.status === 'success'){  
                    if($.isEmptyObject(res.datas) ){
                        $('<div class="text-center text-danger w-100 my-5"></div>').html('No follower found!').appendTo(contents); 
                    }    
                    $('<div class="row m-0"></div>').html(res.html).appendTo(contents);   
                    select_feature_user()
                    submit__feature_user()
                    feature_user_search()
                } 
            },
            complete: function(){
                loader.empty();
            }
        });
    }
    const select_feature_user = () => { 
        $('.feature__users_main').unbind().click(function(){
            $(this).addClass('select__feature_user'); 
            select__user_count();
            cancel_modal($(this))
            submit_datetime_modal($(this))
            $('#feature__date_time').datetimepicker({ 
                inline:true,
                format:'Y-m-d H:i:s',  
            }); 
            
            $('#modal__feature_date_time').modal({backdrop: 'static', keyboard: false});
        })  
    }

    const select__user_count = () =>{
        let selected_users = $('.select__feature_user');
        let users = Array.from(selected_users)
        const users_id = users.map((val) => $(val).data('id')) 
        $('.selected__count').html(users_id.length) 
    } 

    /**
     * for date time modal
     */
 const cancel_modal = (id) => {
    $('.date__time_modal_cencel').unbind().click(()=>{
        $('#modal__feature_date_time').modal('hide') 
        if(id.hasClass('select__feature_user')){
            $(id).removeClass('select__feature_user'); 
            select__user_count(); 
            $('#feature__date_time').datetimepicker('reset')
        } 
    }) 
 }

 
const submit_datetime_modal = (selector) =>{
    $('.users__feature_date_time').unbind().on('click', ()=>{
        var value =  $('#feature__date_time').val(); 
        if(value !== ''){
            $(selector).attr( "data-datetime", value)
            $('#modal__feature_date_time').modal('hide');
        }else{
            alert('Please select datetime!')
        }  
    })
}


const submit__feature_user = () => { 
    const submit__btn  = $('.users__feature_btn');
    submit__btn.unbind().click(function(){
        let selected_users = $('.select__feature_user');
        let users = Array.from(selected_users)
        if(users.length > 0 ){
            const users_id_datetime = users.map((val) =>  {
                return {
                    user_id: $(val).attr('data-id'), 
                    logged_id: logged_id,
                    finished_date: $(val).attr('data-datetime')
                }
            } ); 
            const ids = users.map((val) =>  $(val).data('id'));
            $.ajax({
                url: ajax_url,
                beforeSend: function(){ 
                    $('.users__feature_btn').html('Submit...');  
                },
                data: {action: 'add__feature_list', datas:users_id_datetime, ids: ids,  _token: token},
                dataType: 'JSON',
                type: 'POST',
                success: function (res) {
                    if(res.status === 'success'){
                        load_sidbar();
                        $('#modal__feature_user').modal('hide');
                    } 
                },
                complete: function(){
                    $('.users__feature_btn').html('Submit');  
                }
            })
        }else{
            alert('Please select at least one item!')
        }
    })  
}

const load_sidbar = () =>{

    $.ajax({
        url: ajax_url, 
        data: {action: 'load_sidebar',  _token: token},
        dataType: 'JSON',
        type: 'POST',
        success: function (res) {
            if(res.status === 'success'){
                $('.feature__ul li').not('li:first').remove(); 
                $('.feature__ul').append(res.html);
                delete_feature_user();
            } 
        } 
    })
} 


const delete_feature_user = () =>{
    $('.delete__feature_user').click(function() { 
        let id = $(this).attr('data-id'); 
        if(confirm('Are you sure!')){
            $.ajax({
                url: ajax_url, 
                data: {action: 'delete_feature', id: id,  _token: token},
                dataType: 'JSON',
                type: 'POST',
                context: this,
                success: function (res) {
                    if(res.status === 'success'){
                        $(this).closest('li').remove();
                    } 
                } 
            })
        }
    })
}
delete_feature_user();
const feature_user_search = () =>{
    var content = $('.feature__content');
    var search_item = $('.feature__search_content');
    var search = $('.feature__search_input');
    var loader = $('.feature__search_loader');  
    search.on('keyup',function(){
        var value = $(this).val();
        loader.empty()
        search_item.empty()
        if(value){
            content.css('display','none'); 
            search_item.css('display','block');
            ajax__search(value, loader, search_item);
        }else{ 
            content.css('display','block');
            search_item.css('display','none');
        }
    })

    $('.clear__field').click(()=>{
        $('.feature__search_input').val('')
        content.css('display','block');
        search_item.css('display','none');
    })

    const ajax__search = (value, loader, search_item) =>{ 
        $.ajax({
            url: ajax_url, 
            beforeSend: function(){ 
                search_item.empty();
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div id="loader"></div>').appendTo(loader);  
            },
            data: {action: 'feature_users__search', keyword: value, _token: token},
            dataType: 'JSON',
            type: 'POST',
            context: this,
            success: function (res) {
                if(res.status === 'success'){  
                    if($.isEmptyObject(res.datas) ){
                        search_item.empty();
                        $('<div class="text-center text-danger w-100 py-5"></div>').html('Result not found!').appendTo(search_item); 
                    }else{
                        search_item.empty();
                        $('<div class="row m-0"></div>').html(res.html).appendTo(search_item);  
                    }   
                }
            },
            complete: function(){
                loader.empty();
            }
    }); 
   }
}

}
}); 