@extends('layouts.default')

@section('stylesheet')
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/vendor/no-uislider.css') !!}">
<style>
    @media  (min-device-width: 768px) and (max-device-width: 991px) {
      .filter strong {
           display: block;
        }
    }
    @media  (min-device-width: 1025px) and (max-device-width: 1333px) {
      .filter strong {
           display: block;
        }
    }
#filter__container{
    display: none;
}
.or {
text-align: center;
color: #1f1c1c;
margin: 10px auto;
display: block;
}
</style>
@endsection
@section('content') 

<?php
$seo_social_image = setting('social_image');
$seo_website_description = setting('website_description');
?>
@section('page_description')
    This is the search page for DateV2, Use our awesome search filter to connect with single men and women worldwide.
@endsection
@section('social_image')
    {!! isset($seo_image) ? $seo_image : url($seo_social_image) !!}
@endsection
<div class="main-content">

    <div class="page-title text-capitalize search__filter border-bottom" >
       <div class="w-100"> Search Filter</div>
       <div class="filter__btn"> 
        <span class="btn__icon" >  <svg id="generic-filter" viewBox="0 0 32 32"><path fill="currentColor" fill-rule="evenodd" d="M21 18a7 7 0 016.93 6h3.57c.28 0 .5.22.5.5v1a.5.5 0 01-.5.5h-3.57a7 7 0 01-13.86 0H.5a.5.5 0 01-.5-.5v-1c0-.28.22-.5.5-.5h13.57A7 7 0 0121 18zm0 2a5 5 0 00-4.92 4.12l-.05.3v.08l-.03.31v.43l.01.12.02.21.03.21a5 5 0 009.86.1l.05-.31.01-.12.02-.27-.01-.51-.01-.13-.02-.2-.03-.16A5 5 0 0021 20zM11 0a7 7 0 016.93 6H31.5c.28 0 .5.22.5.5v1a.5.5 0 01-.5.5H17.93A7 7 0 014.07 8H.5a.5.5 0 01-.5-.5v-1c0-.28.22-.5.5-.5h3.57A7 7 0 0111 0zm0 2a5 5 0 00-4.92 4.12l-.05.3v.08L6 6.81v.43l.01.12.02.21.03.21a5 5 0 009.86.1l.05-.31.01-.12.02-.27-.01-.51-.01-.13-.02-.2-.03-.16A5 5 0 0011 2z"></path></svg> </span>
       </div>
    </div>
    @if(session()->has('success_register'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {!! session()->get('success_register') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {!! session()->forget('success_register') !!}
    </div>
    @endif
    <div class="filter shadow-sm p-3 border-bottom bg-white" id="filter__container" >
        <form class="row" action="" id="formFilter" data-min="{{ auth()->check()? auth()->user()->min_age : "" }}" data-max="{{ auth()->check() ? auth()->user()->max_age : ""}} ">
            <div class="col-md-4 order-1 order-lg-1 col-sm-4 border-right">
                <div class="filter">
                    <strong class="d-block">I am a&nbsp;</strong>
                    <div class="custom-control  custom-checkbox custom-control-inline" >
                        <input {{  request()->get('gender') == 'male' || (auth()->check() && auth()->user()->gender == '1') || !auth()->check()?' checked':''  }} type="radio" value="male" id="gender-filter-male" name="gender" class="custom-control-input">
                        <label class="custom-control-label" for="gender-filter-male">Male</label>
                    </div>
                    <div class="custom-control  custom-checkbox custom-control-inline" >
                        <input {{  request()->get('gender') == 'female' || auth()->check() && auth()->user()->gender == '2' ?' checked':''  }} type="radio" value="female" id="gender-filter-female" name="gender" class="custom-control-input">
                        <label class="custom-control-label" for="gender-filter-female">Female</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-3 order-lg-2 col-sm-8 border-right mt-md-2 mt-lg-0">
                <div class="filter">
                    <strong class="d-block">Seeking a&nbsp;</strong>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input {!! in_array(1,$default_preference)?' checked':'' !!} type="checkbox" value="male" id="seeking-filter-male" name="seeking[]" class="custom-control-input">
                        <label class="custom-control-label" for="seeking-filter-male">Male</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input {!! in_array(2,$default_preference)?' checked':'' !!} type="checkbox" value="female" id="seeking-filter-female" name="seeking[]" class="custom-control-input">
                        <label class="custom-control-label" for="seeking-filter-female">Female</label>
                    </div> 
                </div>
                <div class="filter"> 
                    <div class="range_slider_main range_browse_page">
                        <div class="output__range slider-labels">
                            <div>
                                <span>Min age:</span> <strong id="slider-range-value1"></strong>
                            </div>
                            <div>
                                <span>Max age:</span> <strong id="slider-range-value2"></strong>
                            </div> 
                        </div>
                        <div id="slider-range"></div>
                    <input type="hidden" name="min_age" id="min-value" value="">
                    <input type="hidden" name="max_age" id="max-value" value="">
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-primary mr-2 custom__button" type="submit">Search</button> 
                    <button id="cancel__filter" class="btn btn-secondary custom__button" type="button">Cancel</button> 
                </div>
            </div>
            <div class="col-lg-4 order-2 order-lg-3">
                <div class="filter"> 
                        <label for="filter-country" class="country__label">Where</label> 
                        <input class="search__address" name="keywords" id="search__address"> 
                    
                </div> 
                <div class="filter"><span class="or">Or</span>
                    <div class="location__filter">
                        <div class="location__main">
                            Search by Distance <i class="fa fa-location-arrow" id="location__icon" aria-hidden="true"></i> 
                        </div>
                        <div class="location__search">
                            <div class="w-100 h-100 d-flex justify-content-between align-items-center p-2">
                            <input class="range" type="range" min="0" max="10000" value="{{ auth()->user() ? auth()->user()->distance : 1000 }}" step="1"/> 
                             <div class="output"><output id="rangevalue1">{{ auth()->user() ? auth()->user()->distance : 1000 }}</output> Miles</div>
                             <input type="hidden" name="distance" id="distance" value="{{ auth()->user() ? auth()->user()->distance : 1000 }}">
                            </div>
                        </div>
                    </div>
                 </div>
            </div>  
        </form>
    </div>
    <div class="search-content mt-3 ml-2 mr-2 mb-3 col-xs-12">
        @if(count($users))
            <div class="row mb-3 ml-1 mr-1">
            @foreach($users as $user)
                @auth
                <div class="col-xs-12 col-lg-6  col-xl-4 ipad-col"> 
                    @endauth
                    @guest
                    <div class="col-xs-12 col-lg-6  col-xl-3 ipad-col"> 
                    @endguest
                    <a href="{{ route('profile',['username'=>strtolower($user->username)]) }}">
                        <div class="user-item shadow-sm rounded effect" style="background-image: url('{{  avatar($user->avatar, $user->gender) }}') ">
                            <div class="photo__main_content">
                                <div class="photos_status">
                                    <span class="photos">
                                        <i class="fas fa-camera"></i>
                                       {{  $user->photos()->count()  }}</span>
                                        @if($user->isOnline())
                                            <span class="online">
                                                <div class="badge__video_online">Live</div>
                                            </span> 
                                        @endif
                                </div>
                                <div class="users__address">
                                    <p class="fullname m-0">{{  fullname($user->firstname, $user->lastname, $user->username)  }}</p>
                                    <p class="address m-0">{{  fulladdress($user->address, $user->country)  }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            </div>
        @else
        <div class="d-flex justify-content-center flex-column align-items-center mt-5"> 
            <img src="{{ asset('uploads/404.gif') }}" class="img-fluid not__found_img"/>
            <h6 class="text-center">Sorry no users found!</h6><p>Please change your settings or extend your search distance.</p>
        </div>
        @endif
        {!! $users->links() !!}
    </div>
  </div> 
@endsection

@section('javascript')
<script src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_PLACE_API','AIzaSyBjVRkL8MOLaVd-fjloQguTIQDLAAzA4w0') !!}&libraries=places&callback=startMap" async defer></script>
<script src="{!! url('assets/js/vendor/no-uislider.js') !!}"></script>
<script src="{!! url('assets/js/landing.js') !!}"></script> 
@endsection
