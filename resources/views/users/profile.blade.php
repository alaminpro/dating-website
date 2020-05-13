@extends('layouts.profile')
 
@section('page_description')
Hi! My name is {!! fullname($user->firstname, $user->lastname, strtolower($user->username)) !!}
I am {!! Carbon\Carbon::parse($user->birthday)->age !!} Years young :). I am a {!! $user->gender == 1 ? 'Male' :
'Female' !!} Seeking {!! $user->preference == 1 ? 'Male' : ($user->preference == 2 ? 'Female': 'Male and Female') !!}.
@endsection

<?php
$seo_social_image = setting('social_image');
?>
@section('social_image')
<?php
$avatar = avatar($user->avatar, $user->gender);
// dd($user->id);
$avatar2 = substr($avatar, 7, 9);
if ($avatar2 == 'localhost') {
    $avatar = substr($avatar, 34);
    $avatar = 'http://localhost/dating/' . $avatar;
}

?>
{!! url($avatar) !!}
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
}.abt-spc {
    min-height: 88px;
    padding-top: 10px;
    padding-bottom: 10px;
}

.padd-top-10 {
    padding-top: 10px;
}

.padd-top-20 {
    padding-top: 20px;
}

.padd-bottom-20 {
    padding-bottom: 20px;
}

@media (min-device-width: 1900px) and (max-device-width: 2000px) {
    .foo_container {
        margin-left: 16rem !important;
    }
}

@media (min-device-width: 765px) and (max-device-width: 1025px) {
    .online-class {
        left: 40% !important;
    }
}

@media (max-device-width: 576px) {
    .online-class {
        left: 10% !important;
    }
}

@media (min-device-width: 576px) and (max-device-width: 760px) {
    .user-info {
        font-size: 0.75rem !important;
    }

    .online-class
    /* {
        left:55% !important;
    } */
}

.online-class {
    color: #03bf20;
    position: relative;
    top: 47%;
    left: 30px;
    font-weight: 600;
}

.online {
    position: absolute;
    left: 5%;
    color: #02e75c;
}

.profile-min-height {
    min-height: 950px;
}
        .btn-follow:hover{
            color: #fff;
            background: #ff278f
        }
</style>
@endsection
@section('content') 
<div class="landing"> 
    <div class="container-fluid main_container ">
        @include('partials.sidebar')
    <div class="main" id="main__user_id" data-id="{{$user->id}}"> 
            <div class="main-content profile-min-height"> 
                <nav class="navbar navbar-expand navbar-expand-md navbar-expand-lg navbar-light bg-white shadow-sm "
                    id="profile-header">
                    <div class="container">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse">
                            <ul class="navbar-nav mr-auto">
                                @if((auth()->check() && auth()->user()->id != $user->id) || !auth()->check())
                                <li class="nav-item love-760">
                                    <a class="nav-link" href="javascript:void(0)">
                                        <button data-id="{!! $user->id !!}" data-type="like"
                                            class="btn-love<?php echo auth()->check() && auth()->user()->likes()->where('id', $user->id)->first() && auth()->user()->likes()->where('id', $user->id)->first()->pivot->type == 'like' ? ' active' : ''; ?>"><i
                                                class="fas fa-heart"></i></button>
                                    </a>
                                </li>
                                <li class="nav-item hate-760">
                                    <a class="nav-link"
                                        href="{!! $nextuser ? route('profile',['username'=>$nextuser->username]) : route('landing') !!}">
                                        <button class="btn-unlove"><i class="fas fa-times"></i></button>
                                    </a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <div class="mb-1 pl-2 padd-top-10 col-md-8">
                                        <span class="text-capitalize font-weight-bold pr-3 bold">{!!
                                            fullname($user->firstname, $user->lastname, strtolower($user->username)) !!}</span>
                                        <span class="user-info">Age <strong> {!!
                                                Carbon\Carbon::parse($user->birthday)->age !!}</strong>. &nbsp; {!!
                                            $user->gender == 1 ? 'Male' : 'Female' !!}&nbsp; Seeking&nbsp; {!!
                                            $user->preference == 1 ? 'Male' : ($user->preference == 2 ? 'Female': 'Male
                                            and Female') !!} 
                                            @if($user->isOnline())
                                            <span class="online-class">Online Now</span>
                                            @endif
                                        </span>
                                    </div>
                                </li>
                            </ul>
                            @if(auth()->check() && auth()->user()->isFollowEach($user->id))
                            <span class="navbar-text">
                                <a href="{!! route('chat',['id'=>$user->id]) !!}"
                                    class="btn btn-chatter btn-sm border rounded-pill">Chat&nbsp;&nbsp;&nbsp;<i
                                        class="fas fa-comment"></i></a>
                            </span>
                            @endif
                        </div>
                    </div>
                </nav>  
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
                            @if(auth()->check() && auth()->user()->id === $user->id)
                            <a href="{{ route('setting') }}"  class="follow__btn_user btn-follow font-weight-bold">Edit Profile</a>
                            @else
                                @if(auth()->check() && in_array($user->id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
                                    <button class="follow__btn_user btn-follow font-weight-bold" data-id="{!! $user->id !!}" style="padding-left: 30px!important;padding-right: 30px!important;"><i class="fas fa-check pr-1"></i>&nbsp;Followed</button>
                                @else
                                    <button class="follow__btn_user btn-follow font-weight-bold" data-id="{!! $user->id !!}" style="padding-left: 30px!important;padding-right: 30px!important;">Follow</button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
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
            <div class="modal" id="modalPhoto" tabindex="-1" role="dialog" data-backdrop="static"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div>

<!-- </div> -->
@endsection

@section('javascript') 
<script src="{!! url('assets/js/profile.js') !!}"></script>
@endsection
