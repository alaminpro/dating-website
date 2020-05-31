@extends('layouts.photo')
<?php
$seo_social_image = setting('social_image');
$seo_website_description = setting('website_description');
?>
@section('page_description')

    Hi! My name is {!! fullname($user->firstname, $user->lastname, $user->username) !!}. Check out my photo page, view all my latest images and follow my posts for more updates.
@endsection
@section('social_image')
<?php
                      $avatar = avatar($user->avatar, $user->gender);
                      $avatar2 = substr($avatar,7,9);
                      if ($avatar2 == 'localhost') {
                        $avatar = substr($avatar,34);
                        $avatar ='http://localhost/dating/'.$avatar;
                      }
                       ?>
    {!! $avatar ?? '' !!}
@endsection
@section('stylesheet')

<style>
    .h1, h1 {
        font-size: 1.9rem;
    } 
     
.LoaderBalls {
    width: 90px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.LoaderBalls__item {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #ff007c;
}
.LoaderBalls__item:nth-child(1) {
    animation: bouncing 0.4s alternate infinite
        cubic-bezier(0.6, 0.05, 0.15, 0.95);
}
.LoaderBalls__item:nth-child(2) {
    animation: bouncing 0.4s 0.1s alternate infinite
        cubic-bezier(0.6, 0.05, 0.15, 0.95) backwards;
}
.LoaderBalls__item:nth-child(3) {
    animation: bouncing 0.4s 0.2s alternate infinite
        cubic-bezier(0.6, 0.05, 0.15, 0.95) backwards;
}

@keyframes bouncing {
    0% {
        transform: translate3d(0, 10px, 0) scale(1.2, 0.85);
    }
    100% {
        transform: translate3d(0, -20px, 0) scale(0.9, 1.1);
    }
}
        
    </style>
@endsection
@section('content')

    <div class="container-fluid main_container photos">
        {{--@if(!auth()->check())--}}
            @include('partials.sidebar')
            <div class="main">
                {{--@endif--}}
                <div class="main-content"><p class="page-title mb-2 pl-3">Recent Posts</p>
                @if(!auth()->check())
                <div class="top-photo pb-3 pl-3">
                    <div class="custom__photo_middle">
                      <?php
                      $avatar = avatar($user->avatar, $user->gender);
                      $avatar2 = substr($avatar,7,9);
                      if ($avatar2 == 'localhost') {
                        $avatar = substr($avatar,34);
                        $avatar ='http://localhost/dating/'.$avatar;
                      }
                       ?>
                         <div class="img-div">
                             <a href="{!! route('profile',['username'=>$user->username]) !!}">
                                <img width="200" src="{!! $avatar !!}" class="border rounded-circle img-responsive">
                            </a>
                        </div>
                         <div class="user__info">
                            <h1 class="user__username">{!! fullname($user->firstname, $user->lastname, $user->username) !!}</h1>
                            <p class="font-weight-bold m-0 py-1">
                                @<a href="{!! route('profile',['username'=>$user->username]) !!}">{!! $user->username !!} </a>
                            </p>
                           @if(auth()->check() && in_array($user->id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
                                <button class="follow__btn_user btn-follow font-weight-bold" data-id="{!! $user->id !!}" style="padding-left: 30px!important;padding-right: 30px!important;"><i class="fas fa-check pr-1"></i>&nbsp;Followed</button>
                            @else
                                <button class="follow__btn_user btn-follow font-weight-bold" data-id="{!! $user->id !!}" style="padding-left: 30px!important;padding-right: 30px!important;">Follow</button>
                            @endif
                        </div>
                    </div>
                </div>
                 @elseif(auth()->user()->id != $user->id)
                <div class="top-photo pb-3 pl-3">
                    <div class="custom__photo_middle">
                      <?php
                      $avatar = avatar($user->avatar, $user->gender);
                      $avatar2 = substr($avatar,7,9);
                      if ($avatar2 == 'localhost') {
                        $avatar = substr($avatar,34);
                        $avatar ='http://localhost/dating/'.$avatar;
                      }
                       ?>
                        <div class="img-div">
                            <a href="{!! route('profile',['username'=>$user->username]) !!}">
                                <img width="200" src="{!! $avatar !!}" class="border rounded-circle img-responsive">
                            </a>
                        </div>
                        <div class="user__info">
                            <h1 class="user__username">{!! fullname($user->firstname, $user->lastname, $user->username) !!}</h1>
                            <p class="font-weight-bold m-0 py-1">@<a href="{!! route('profile',['username'=>$user->username]) !!}">{!! $user->username !!}</a></p>
                            @if(auth()->check() && in_array($user->id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
                                <button class="follow__btn_user btn-follow font-weight-bold" data-id="{!! $user->id !!}" style="padding-left: 30px!important;padding-right: 30px!important;"><i class="fas fa-check  pr-1"></i>Followed</button>
                            @else
                                <button class="follow__btn_user btn-follow font-weight-bold" data-id="{!! $user->id !!}" style="padding-left: 20px!important;padding-right: 20px!important;">Follow</button>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                <div class="main-photos">
                    <div class="material__tabs">
                        <ul class="material__tab_ul">
                            <li class="about__us">About</li>
                            <li class="posts">
                                <div class="d-flex justify-content-center flex-column align-items-center">
                                    <b>{!! $user->photos()->count() !!}</b> 
                                    <span class="d-block">Posts</span>
                                </div>
                            </li>
                            <li class="follow__followers">
                                <div class="d-flex justify-content-center flex-column align-items-center">
                                    <b>{!! $user->following()->count() !!}</b> 
                                    <span class="d-block">Followers</span>
                                </div>
                            </li>
                            <li class="follow__following"> 
                                <div class="d-flex justify-content-center flex-column align-items-center">
                                    <b>{!! $user->follows()->count() !!}</b> 
                                    <span class="d-block">Following</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="row contents"></div> 
                        <div class="loader"></div>    
                        <div class="not_found mt-4"></div>
                        <div class="d-flex justify-content-center mt-4" id="load__more_main"></div>
                    </div>
                </div>
              </div>
                @include('partials.footer') 
                <div class="modal" id="modalPhoto" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                            </div>
                        </div>
                    </div>
                </div>
            @if(!auth()->check())
            </div>
            @endif
    </div>
@endsection

@section('javascript')

<script>
  
var user_id = '{{ $user->id }}';
var token = $('meta[name=csrf_token]').attr('content');
$(document).ready(function() { 
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
        $(this).addClass('active'); 
        posts.removeClass('active');
        followers.removeClass('active');
        following.removeClass('active');  
        queryParams('?type=about')
        ajax_about() 
    })
    posts.off('click').on('click',function(){
        $(this).addClass('active'); 
        about_us.removeClass('active'); 
        followers.removeClass('active');
        following.removeClass('active');  
        queryParams('?type=posts')
        ajax_posts() 
    })

    followers.off('click').on('click',function(){
        $(this).addClass('active'); 
        about_us.removeClass('active'); 
        posts.removeClass('active'); 
        following.removeClass('active'); 
        queryParams('?type=followers')
        ajax_followers() 
    })
    following.off('click').on('click',function(){
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
                    $(' <div class="pl-3"> </div>').html(res.html).appendTo(contents); 
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
                        $.toast({
                            heading: 'Warning',
                            text: 'Data not found!', 
                            icon: 'warning',
                            position: 'bottom-right',
                        })
                    }  
                    $(' <div class="pl-3" style="width: 98%;"> </div>').html(res.html).appendTo(contents);

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
                                <a href="/u/'+data.username +'" target="_blank">\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="/'+ data.avatar +'" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/'+data.username +'" target="_blank"><p class="follo__user_name">'+data.username+'</p></a>\
                                    '+follows+'\
                                </div>\
                            </div>').appendTo(contents);
                        }else{
                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                <a href="/u/'+data.username +'" target="_blank">\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="/assets/images/1.jpg" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/'+data.username +'" target="_blank"><p class="follo__user_name">'+data.username+'</p></a>\
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
                                not_found.empty();
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
                                                <a href="/u/'+data.username +'" target="_blank">\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="'+ data.avatar +'" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/'+data.username +'" target="_blank"><p class="follo__user_name">'+data.username+'</p></a>\
                                                    '+follows+'\
                                                </div>\
                                            </div>').appendTo(contents);
                                        }else{
                                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                                <a href="/u/'+data.username +'" target="_blank">\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="/assets/images/1.jpg" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/'+data.username +'" target="_blank"><p class="follo__user_name">'+data.username+'</p></a>\
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
                                <a href="/u/'+data.username +'" target="_blank">\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="/'+ data.avatar +'" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/'+data.username +'" target="_blank"><p class="follo__user_name">'+data.username+'</p></a>\
                                   '+following+'\
                                </div>\
                            </div>').appendTo(contents);
                        }else{
                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                <a href="/u/'+data.username +'" target="_blank">\
                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                        <img src="/assets/images/1.jpg" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                    </div>\
                                </a>\
                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                    <a href="/u/'+data.username +'" target="_blank"><p class="follo__user_name">'+data.username+'</p></a>\
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
                                not_found.empty();
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
                                                <a href="/u/'+data.username +'" target="_blank">\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="'+ data.avatar +'" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/'+data.username +'" target="_blank"><p class="follo__user_name">'+data.username+'</p></a>\
                                                    '+following+'\
                                                </div>\
                                            </div>').appendTo(contents);
                                        }else{
                                            $('<div class="col-lg-3 col-sm-4 col-6 mt-4"></div>').html('<div class="follow__content" data-id="'+ data.id +'">\
                                                <a href="/u/'+data.username +'" target="_blank">\
                                                    <div class="d-flex justify-content-center mb-2" style="height: 100px" >\
                                                        <img src="/assets/images/1.jpg" alt="'+ data.username +'" class="img-fluid rounded-circle" width="100">\
                                                    </div>\
                                                </a>\
                                                <div class="d-flex justify-content-center align-items-center flex-column">\
                                                    <a href="/u/'+data.username +'" target="_blank"><p class="follo__user_name">'+data.username+'</p></a>\
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
</script>
 
@endsection
