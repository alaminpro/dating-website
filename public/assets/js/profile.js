$(document).ready(function() {  
    var user_id = $('#main__user_id').data('id');
    var token = $('meta[name=csrf_token]').attr('content');
    var loader = $('.loader')
    var about_us = $('.about__us');
    var posts = $('.posts');
    var followers = $('.follow__followers');
    var following = $('.follow__following');
    var contents = $('.contents'); 
    if(!location.search){
        queryParams('?type=posts');
    } 
    
    if(getQueryParams() === 'about' || getQueryParams() === 'posts' || getQueryParams() === 'followers' || getQueryParams() === 'following'){
        var follow = getQueryParams();
        if(follow === 'about'){
            ajax_about();
        }else if(follow === 'posts'){
            ajax_posts();
        }else if(follow === 'followers'){
            ajax_followers();
        }else if(follow === 'following'){
            ajax_following();
        } 
    }
  
    if(getQueryParams() === 'about'){
        about_us.addClass('active');
        posts.removeClass('active');
        followers.removeClass('active');
        following.removeClass('active'); 
    }else if(getQueryParams() === 'posts'){
        about_us.removeClass('active');
        posts.addClass('active');
        followers.removeClass('active');
        following.removeClass('active'); 
    }
    else if(getQueryParams() === 'followers'){
        about_us.removeClass('active');
        posts.removeClass('active');
        followers.addClass('active');
        following.removeClass('active'); 
    }
    else if(getQueryParams() === 'following'){
        about_us.removeClass('active');
        posts.removeClass('active');
        followers.removeClass('active');
        following.addClass('active'); 
    } 

    about_us.off('click').on('click',function(){
        contents.empty();
        loader.empty();
        $('.custom__load_more_btn').remove();
        $(this).addClass('active'); 
        posts.removeClass('active');
        followers.removeClass('active');
        following.removeClass('active');  
        queryParams('?type=about')
        ajax_about() 
    })
    posts.off('click').on('click',function(){
        contents.empty();
        $('.custom__load_more_btn').remove();
        loader.empty();
        $(this).addClass('active'); 
        about_us.removeClass('active'); 
        followers.removeClass('active');
        following.removeClass('active');  
        queryParams('?type=posts')
        ajax_posts() 
    })

    followers.off('click').on('click',function(){
        contents.empty();
        $('.custom__load_more_btn').remove();
        loader.empty();
        $(this).addClass('active'); 
        about_us.removeClass('active'); 
        posts.removeClass('active'); 
        following.removeClass('active'); 
        queryParams('?type=followers')
        ajax_followers() 
    })
    following.off('click').on('click',function(){
        contents.empty();
        $('.custom__load_more_btn').remove();
        loader.empty();
        $(this).addClass('active'); 
        about_us.removeClass('active'); 
        posts.removeClass('active'); 
        followers.removeClass('active');  
        queryParams('?type=following')
        ajax_following() 
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
        return queries.type 
    } 
    function ajax_about(){
        return  $.ajax({
            url: ajax_url, 
            beforeSend: function(){
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div class="LoaderBalls mt-5"><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div></div>').appendTo(loader);
                contents.empty()
            },
            data: {action: 'about_us_section', id: user_id, _token: token},
            dataType: 'JSON',
            type: 'POST',
            context: this,
            success: function (res) {
                if(res.status === 'success'){ 
                    $(' <div class="pl-3 w-100"> </div>').html(res.html).appendTo(contents); 
                }else{
                    $('<div class="w-100 d-flex justify-content-center align-items-center text-danger"></div>').html('Something went wrong!').appendTo(contents);
                }
            },
            complete: function(){
                loader.empty();
            }
        });
    }
    function ajax_posts(){
        return  $.ajax({
            url: ajax_url, 
            beforeSend: function(){
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div class="LoaderBalls mt-5"><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div></div>').appendTo(loader);
                contents.empty()
            },
            data: {action: 'fetch_user_photos', id: user_id, _token: token},
            dataType: 'JSON',
            type: 'POST',
            context: this,
            success: function (res) {
                if(res.status === 'success'){   
                    if($.isEmptyObject(res.user.photos)){
                        loader.empty()
                        $.toast({
                            heading: 'Warning',
                            text: 'Data not found!', 
                            icon: 'warning',
                            position: 'bottom-right',
                        })
                      
                    }  
                    $('<div class="pl-3" style="width: 98%;"></div>').html(res.html).appendTo(contents);
                    $('.add-photo').click(function(){ 
                        $("#formUpload").trigger('reset');
                        $('#result').empty(); 
                        $('#upload-photo').click(); 
                        $('#upload-image').attr('value', '')
                        $('.custom-alert').remove(); 
                        $('.btn__description').removeClass('d-block');
                        $('.cropper-wrapper').removeClass('d-none');
                        $('.btn__description').addClass('d-none');
                        $('.cropper-wrapper').addClass('d-block');
                        $('#btnCrop').removeClass('d-none');
                        $('#btnRestore').removeClass('d-none');
                    });  
                 var uploadProgress = $('.upload-progress');
                    $(document).on('click', '#upload-btn', function(e) {
                        const crop_img = $('#upload-image').val();
                        if(crop_img != ''){
                            $('#formUpload').ajaxForm({
                                beforeSend: function () {
                                    uploadProgress.css({opacity:1});
                                    uploadProgress.find('.progress-bar').css({width: 0});
                                    uploadProgress.find('.progress-bar').attr('aria-valuenow', 0);
                                },
                                uploadProgress: function(event, position, total, percentComplete) {
                                    var percentVal = percentComplete + '%';
                                    uploadProgress.find('.progress-bar').css({width: percentVal});
                                    uploadProgress.find('.progress-bar').attr('aria-valuenow', percentComplete);
                                },
                                complete: function(xhr) {
                                    var result = JSON.parse(xhr.responseText);
                                    if(result.status === 'success'){
                                        var html = '<div class="col-md-3 ipad-photo-img content__each">';
                                        html += '<div class="photo-item view-photo" data-id="'+result.id+'" data-url="'+result.file+'" style="background-image: url('+result.thumb+')"></div>';
                                        html += '</div>';

                                        var content_first =  $('.content__each:first'); 
                                       if(content_first){
                                            content_first.after(html);
                                       }else{
                                            $('.content__each').appendTo(html); 
                                       }
                                    }
                                    $('#modalUpload').find('textarea').val('');
                                    $('#modalUpload').modal('hide');
                                    uploadProgress.find('.progress-bar').css({width: 0});
                                    uploadProgress.find('.progress-bar').attr('aria-valuenow', 0);
                                    uploadProgress.css({opacity:0});
                                }
                            });
                        } else{
                            e.preventDefault() 
                           $(".alert-image").append('<p class="custom-alert m-0 p-0 ">Crop this image first</p>');
                        }
                      }); 
                      var canvas  = $("#canvas"), 
                        $result = $('#result'),
                        cropper = '';
                        $('#upload-photo').on('change', function (e) {
                            if($(this).get(0).files.length){
                                $('#modalUpload').modal('show');
                                $('#canvas').empty()
                                if (this.files && this.files[0]) {
                                    if ( this.files[0].type.match(/^image\//) ) {
                                    var reader = new FileReader();
                                    reader.onload = function(evt) { 
                                        if(evt.target.result){ 
                                            let img = document.createElement('img');
                                            img.id = 'image';
                                            img.src = evt.target.result 
                                            canvas.innerHTML = ''; 
                                            canvas.append(img); 
                                            cropper = new Cropper(img, {
                                                viewMode: 1,
                                                aspectRatio: 4/3, 
                                                minContainerWidth: 500, 
                                                minContainerHeight: 375, 
                                                movable: true, 
                                            });
                                            
                                        }
                                        $('#btnCrop').click(function() {
                                                $result.empty();
                                                var croppedImageDataURL = cropper.getCroppedCanvas().toDataURL("image/jpeg", 0.5); 
                                                $result.append( $('<img>').attr('src', croppedImageDataURL) );
                                                $('#upload-image').attr('value', croppedImageDataURL)
                                                $('.custom-alert').remove();
                                                $('.btn__description').removeClass('d-none');
                                                $('.cropper-wrapper').removeClass('d-block');
                                                $('.btn__description').addClass('d-block');
                                                $('.cropper-wrapper').addClass('d-none');
                                                $(this).addClass('d-none');
                                                $('#btnRestore').addClass('d-none');
                                        });
                                        $('#btnRestore').click(function() {
                                            $('#upload-image').attr('value', '')
                                                cropper.reset();
                                                $result.empty();
                                                $('.custom-alert').remove();
                                            });
                                    
                                    };
                                    reader.readAsDataURL(this.files[0]);
                                    }
                                    else {
                                    alert("Invalid file type! Please select an image file.");
                                    }
                                }
                                else {
                                    alert('No file(s) selected.');
                                }
                            }

                        });
                       
                       /**
                     *  load more hide and show
                     * */
                     var count = [];
                        $( ".content__each" ).each(function() {
                            count.push($( this ).data('id'));
                        });  
                    var load = $('.load_more_photo'); 
                    if(count.length >= 15){ 
                        load.removeClass('d-none');
                        load.addClass('d-block');
                    }else{
                        load.addClass('d-none');
                        load.removeClass('d-block');
                    }

                       /**
                     *  load more 
                     * */
                     load.on('click',function(){ 
                        var el = $(this);
                        var id = el.attr('data-id');
                        var data_id = []
                        $( ".content__each" ).each(function() {
                            data_id.push($( this ).data('id'));
                        }); 
                        var item = 15;
                        $.ajax({
                            url: ajax_url, 
                            beforeSend: function(){
                                el.addClass('loading');
                            },
                            data: {action: 'load_more_photo', id: id, data_id: data_id, item: item, _token: token},
                            dataType: 'JSON',
                            type: 'POST',
                            context: this,
                            success: function (res) { 
                                if($.isEmptyObject(res.datas)){ 
                                    $.toast({
                                        heading: 'Warning',
                                        text: 'Data not found!', 
                                        icon: 'warning',
                                        position: 'bottom-right',
                                    })
                                }  
                                if(res.status === 'success'){ 
                                    $('.load__more_append').append(res.html) 
                                } 
                            },
                            complete: function(){
                                el.removeClass('loading');
                            }
                        });
                    })
                }else{
                    loader.empty()
                    $('<div class="w-100 d-flex justify-content-center align-items-center text-danger"></div>').html('Something went wrong!').appendTo(contents);
                }
            },
            complete: function(){
                loader.empty();
            }
        });
    }
    function ajax_followers(){
        return  $.ajax({
            url: ajax_url_follow, 
            beforeSend: function(){
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div class="LoaderBalls mt-5"><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div></div>').appendTo(loader);
                contents.empty()
            },
            data: {action: 'get_followers', id: user_id, logged_id:logged_id, _token: token},
            dataType: 'JSON',
            type: 'POST',
            context: this,
            success: function (res) {
                if(res.status === 'success'){ 
                    if($.isEmptyObject(res.datas)){
                        $('<div class="text-center text-danger w-100 my-5"></div>').html('Data not found!').appendTo(contents);
                        $.toast({
                            heading: 'Warning',
                            text: 'Data not found!', 
                            icon: 'warning',
                            position: 'bottom-right',
                        })
                    }  
                    $.map(res.datas, function(data) {
                        if(logged_id){
                            if(data.follow != ''){
                                var follows = '<button type="button" class="follow__btn" data-id="'+ data.id +'"><div class="btn_text">'+ data.follow +'</div> <div class="loading"></div></button>';
                            }else{
                                var follows = '';
                                            }
                        }else{
                            var follows = '';
                        }
                        if(data.avatar){
                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                <a href="/u/'+data.username +'">\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="/'+ data.avatar +'" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/'+data.username +'"><p class="follo__user_name">'+data.username+'</p></a>\
                                    '+follows+'\
                                </div>\
                            </div>').appendTo(contents);
                        }else{
                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                <a href="/u/'+data.username +'">\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="/assets/images/1.jpg" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/'+data.username +'"><p class="follo__user_name">'+data.username+'</p></a>\
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
                            data: {action: "follow_following", id: id,  _token: token},
                            dataType: 'JSON',
                            type: 'POST',
                            context: this,
                            success: function (res) {
                                if(res.status === 'success'){ 
                                    btn.html(res.data)
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
                            data: {action: 'get_followers', id: user_id, data_id: data_id, logged_id:logged_id, item: item, _token: token},
                            dataType: 'JSON',
                            type: 'POST',
                            context: this,
                            success: function (res) { 
                                if(res.status === 'success'){ 
                                    if($.isEmptyObject(res.datas)){ 
                                        $.toast({
                                            heading: 'Warning',
                                            text: 'Data not found!', 
                                            icon: 'warning',
                                            position: 'bottom-right',
                                        })
                                    }  
                                    $.map(res.datas, function(data) {
                                        if(logged_id){
                                            if(data.follow != ''){
                                            var follows = '<button type="button" class="follow__btn" data-id="'+ data.id +'"><div class="btn_text">'+ data.follow +'</div> <div class="loading"></div></button>';
                                            }else{
                                                var follows = '';
                                            }
                                        }else{
                                            var follows = '';
                                        }
                                        if(data.avatar){
                                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                                <a href="/u/'+data.username +'">\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="/'+ data.avatar +'" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/'+data.username +'"><p class="follo__user_name">'+data.username+'</p></a>\
                                                    '+follows+'\
                                                </div>\
                                            </div>').appendTo(contents);
                                        }else{
                                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                                <a href="/u/'+data.username +'">\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="/assets/images/1.jpg" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/'+data.username +'"><p class="follo__user_name">'+data.username+'</p></a>\
                                                    '+follows+'\
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
    function ajax_following(){
        return  $.ajax({
            url: ajax_url_follow, 
            beforeSend: function(){
                $('<div class="w-100 d-flex justify-content-center align-items-center"></div>').html('<div class="LoaderBalls mt-5"><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div><div class="LoaderBalls__item"></div></div>').appendTo(loader);
                contents.empty()
            },
            data: {action: 'get_following', id: user_id, logged_id:logged_id,  _token: token},
            dataType: 'JSON',
            type: 'POST',
            context: this,
            success: function (res) {
                if(res.status === 'success'){ 
                    if($.isEmptyObject(res.datas)){
                        $('<div class="text-center text-danger w-100 my-5"></div>').html('Data not found!').appendTo(contents);
                        $.toast({
                            heading: 'Warning',
                            text: 'Data not found!', 
                            icon: 'warning',
                            position: 'bottom-right',
                        })
                    }  
                    $.map(res.datas, function(data) {
                        if(logged_id == user_id){
                            if(data.follow != ''){
                            var following = '<button type="button" class="following__btn" data-id="'+ data.id +'"><div class="btn_text">'+ data.follow +'</div> <div class="loading"></div></button>';
                            }else{
                                                var following = '';
                                            }
                        }else if(logged_id){
                            if(data.follow != ''){
                            var following = '<button type="button" class="follow__btn" data-id="'+ data.id +'"><div class="btn_text">'+ data.follow +'</div> <div class="loading"></div></button>';
                            }else{
                                                var following = '';
                                            }
                        } else{
                              var following = '';
                            }
                        if(data.avatar){
                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                <a href="/u/'+data.username +'">\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="/'+ data.avatar +'" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/'+data.username +'"><p class="follo__user_name">'+data.username+'</p></a>\
                                   '+following+'\
                                </div>\
                            </div>').appendTo(contents);
                        }else{
                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                <a href="/u/'+data.username +'">\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="/assets/images/1.jpg" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/'+data.username +'"><p class="follo__user_name">'+data.username+'</p></a>\
                                    '+following+'\
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
                    $('.follow__btn').on('click', function(){
                        var id= $(this).data('id'); 
                        var btn = $(this);
                        $.ajax({
                            url: ajax_url_follow,  
                            data: {action: "follow_following", id: id,  _token: token},
                            dataType: 'JSON',
                            type: 'POST',
                            context: this,
                            success: function (res) {
                                if(res.status === 'success'){ 
                                    btn.html(res.data)
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
                            data: {action: 'get_following', id: user_id, data_id: data_id,logged_id:logged_id, item: item, _token: token},
                            dataType: 'JSON',
                            type: 'POST',
                            context: this,
                            success: function (res) { 
                                if(res.status === 'success'){ 
                                    if($.isEmptyObject(res.datas)){
                                        $.toast({
                                            heading: 'Warning',
                                            text: 'Data not found!', 
                                            icon: 'warning',
                                            position: 'bottom-right',
                                        })
                                    }  
                                    $.map(res.datas, function(data) {
                                        if(logged_id == user_id){
                                            if(data.follow != ''){
                                            var following = '<button type="button" class="following__btn" data-id="'+ data.id +'"><div class="btn_text">'+ data.follow +'</div> <div class="loading"></div></button>';
                                            }else{
                                                var following = '';
                                            }
                                        }else if(logged_id){
                                            if(data.follow != ''){
                                            var following = '<button type="button" class="follow__btn" data-id="'+ data.id +'"><div class="btn_text">'+ data.follow +'</div> <div class="loading"></div></button>';
                                            }else{
                                                var following = '';
                                            }
                                        }
                                        else{
                                                var following = '';
                                            }
                                        if(data.avatar){
                                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                                <a href="/u/'+data.username +'">\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="/'+ data.avatar +'" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/'+data.username +'"><p class="follo__user_name">'+data.username+'</p></a>\
                                                    '+following+'\
                                                </div>\
                                            </div>').appendTo(contents);
                                        }else{
                                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                                <a href="/u/'+data.username +'">\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="/assets/images/1.jpg" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/'+data.username +'"><p class="follo__user_name">'+data.username+'</p></a>\
                                                    '+following+'\
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
   
}); 