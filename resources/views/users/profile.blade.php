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
        <nav class="navbar navbar-expand navbar-expand-md navbar-expand-lg navbar-light bg-white shadow-sm "
        id="profile-header">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto"> 
                    <li class="nav-item">
                        <div class="mb-1 pl-2">
                            <h1 class="user__username">{!! fullname($user->firstname, $user->lastname, $user->username) !!}, {!! Carbon\Carbon::parse($user->birthday)->age !!}</h1> 
                        </div>
                    </li>
                </ul>
                @if((auth()->check() && auth()->user()->id != $user->id) || !auth()->check())
                <div class="nav-item hate-760">
                    <a class="nav-link"
                        href="{!! $nextuser ? route('profile',['username'=>$nextuser->username]) : route('landing') !!}">
                        <button class="btn-unlove"><i class="fas fa-times"></i></button>
                    </a>
                </div>
                <div class="nav-item love-760">
                    <a class="nav-link" href="javascript:void(0)">
                        <button data-id="{!! $user->id !!}" data-type="like"
                            class="btn-love<?php echo auth()->check() && auth()->user()->likes()->where('id', $user->id)->first() && auth()->user()->likes()->where('id', $user->id)->first()->pivot->type == 'like' ? ' active' : ''; ?>"><i
                                class="fas fa-heart"></i></button>
                    </a>
                </div> 
            @endif
                @if(auth()->check() && auth()->user()->isFollowEach($user->id))
                    <span class="navbar-text">
                        <a href="{!! route('chat',['id'=>$user->id]) !!}"
                            class="btn-chatter"><i class="fas fa-comment-dots"></i></a>
                    </span> 
                @endif
                @if(auth()->check() && auth()->user()->isFollowEach($user->id))
                    <span class="navbar-text">
                        <p class="video__icon p-0 m-0" data-id="{{ $user->id }}" style="cursor: pointer">
                            <i class="fas fa-video" style="font-size: 21px;background: white;border: 1px solid;padding: 14px;border-radius: 50%;color: #0f8e64;margin-left: 2px;"></i>
                        </p>
                    </span>  
                @endif
               
            </div>
        </div>
    </nav>
            <div class="main-content profile-min-height">  
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
                             <a href="{!! route('profile',['username'=>$user->username]) !!}" class="profile__photo">
                                @if($user->isOnline())
                                 <span class="online-class"></span>
                                @endif
                                <img width="200" src="{!! $avatar !!}" class="border rounded-circle img-responsive">
                            </a>
                        </div>
                         <div class="user__info">
                            
                            <p class="font-weight-bold m-0 profile__username">
                                @<span>{!! $user->username !!} </span>
                            </p>
                            <span class="seeking">
                                {!!
                                    $user->gender == 1 ? 'Male' : 'Female' !!} Seeking {!!
                                    $user->preference == 1 ? ' Male' : ($user->preference == 2 ? ' Female': ' Male
                                    and Female') !!} 
                            </span>
                            <div class="profile__location py-1">
                                <i class="fas fa-map-marker-alt"></i> {{ $user->address }}
                            </div>
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
<script>
     $(document).ready(function(){
      var token = $('meta[name=csrf_token]').attr('content');   

      $(document).on('click', '.video__icon', function (event) {
        var el = $(event.currentTarget);
        var id = el.attr('data-id');
        $.ajax({
            url:ajax_url,
            data: {action: 'permission', id: id, _token: token},
            dataType: 'JSON',
            type: 'POST', 
            success: function (res) { 
                if(res.status === 'success'){ 
                  window.location.href = res.url
                }
            }
        })
    });
     });
</script>
@endsection
