@extends('layouts.default')
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
        <div class="main-content"> 
                    <div class="page-title text-capitalize m-0">
                        <h2 class="m-0">Recent Posts</h2>
                    </div>
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

 