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
@section('content')
<style>.h1, h1 {
	font-size: 1.9rem;
}
.img-div {
  width: 190px;
padding: 20px;
}
.img-responsive {
width:100%;
}
.rad8 {
border-radius:8px !important;
}
.insta-row {
display:flex;
border-bottom:#f6f6f6;
margin-bottom:5px;
}
</style>
    <div class="container-fluid main_container photos">
        {{--@if(!auth()->check())--}}
            @include('partials.sidebar')
            <div class="main">
                {{--@endif--}}
                <div class="main-content"><p class="page-title mb-2 pl-3">Recent Posts</p>
                @if(!auth()->check())
                <div class="top-photo pt-3 pb-3 pl-3">
                    <div class="media">
                      <?php
                      $avatar = avatar($user->avatar, $user->gender);
                      $avatar2 = substr($avatar,7,9);
                      if ($avatar2 == 'localhost') {
                        $avatar = substr($avatar,34);
                        $avatar ='http://localhost/dating/'.$avatar;
                      }
                       ?>
                        <img src="{!! $avatar !!}" class="mr-3 border rad8 w-20"></a>
                        <div class="media-body">
                            <p class="font-weight-bold">@<a href="{!! route('profile',['username'=>$user->username]) !!}">{!! $user->username !!} </a></p>
                           <!-- <p>Likes {!! $user->likes()->count() !!}</p> -->
                            @if(auth()->check() && in_array($user->id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
                                <button class="btn btn-sm btn-primary font-weight-bold btn-follow" data-id="{!! $user->id !!}" style="padding-left: 30px!important;padding-right: 30px!important;"><i class="fas fa-check"></i>&nbsp;Followed</button>
                            @else
                                <button class="btn btn-sm btn-primary font-weight-bold btn-follow" data-id="{!! $user->id !!}" style="padding-left: 30px!important;padding-right: 30px!important;">Follow</button>
                            @endif
                        </div>
                    </div>
                </div>
                 @elseif(auth()->user()->id != $user->id)
                <div class="top-photo pt-3 pb-3 pl-3">
                    <div class="media">
                      <?php
                      $avatar = avatar($user->avatar, $user->gender);
                      $avatar2 = substr($avatar,7,9);
                      if ($avatar2 == 'localhost') {
                        $avatar = substr($avatar,34);
                        $avatar ='http://localhost/dating/'.$avatar;
                      }
                       ?>
                        <div class="img-div"><a href="{!! route('profile',['username'=>$user->username]) !!}"><img src="{!! $avatar !!}" class="mr-3 border rounded-circle img-responsive"></a></div>
                        <div class="media-body"><h1>{!! fullname($user->firstname, $user->lastname, $user->username) !!}</h1>
                            <p class="font-weight-bold">@<a href="{!! route('profile',['username'=>$user->username]) !!}">{!! $user->username !!}</a></p>
                           <!-- <p>Likes {!! $user->likes()->count() !!}</p> -->
                            @if(auth()->check() && in_array($user->id, collect(auth()->user()->follows()->get())->pluck('id')->all()))
                                <button class="btn btn-sm btn-primary font-weight-bold btn-follow" data-id="{!! $user->id !!}" style="padding-left: 30px!important;padding-right: 30px!important;"><i class="fas fa-check"></i>Followed</button>
                            @else
                                <button class="btn btn-sm btn-primary font-weight-bold btn-follow" data-id="{!! $user->id !!}" style="padding-left: 20px!important;padding-right: 20px!important;">Follow</button>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                <div class="main-photos mh-550">
                    <div class="insta-row">
                    <div class="col-md-4 text-center"><b>{!! $user->photos()->count() !!}</b><br>Posts</div>
                    <div class="col-md-4 text-center"><b>{!! $user->following()->count() !!}</b><br>Followers</div>
                    <div class="col-md-4 text-center"><b>{!! $user->follows()->count() !!}  </b><br>Following</div></div>
                    @if($user->photos()->count())
                    <div class="pl-3"><!-- page-title pl-3 -->
                        <div class="row mr-1 mh-400"><!-- pl-2 -->
                            @foreach($user->photos()->orderBy('created_at','DESC')->get()->take(16) as $photo)

                            <?php
                            $url = url()->full();
                            $url2 = substr($url,7,9);
                            if ($url2 == 'localhost') {
                              $cover = 'http://localhost/dating/'.$photo->thumb;
                            }else {
                              $cover = $photo->thumb;
                            }
                             ?>
                                <div class="col-md-3 ipad-photo-img">
                                    <div data-id="{!! $photo->id !!}" data-url="{!! url($photo->file) !!}" class="photo-item view-photo border shadow style" style="background-repeat: no-repeat;
                                            background-size: cover; background-position: center; background-image: url('{!! url($cover) !!}');">

                                    </div>
                                </div>
                            @endforeach
                        </div>
<div class="text-center mt-3 pb-3">
                            <button data-id="{!! $user->id !!}" data-page="1" class="load_more_photo btn btn-sm btn-primary" style="padding-left: 30px!important;padding-right: 30px!important;"><i class="fas fa-spinner fa-spin"></i> Load more</button>
                        </div>
                        </div>
                        
                    @else
                    @endif
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
