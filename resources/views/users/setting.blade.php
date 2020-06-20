@extends('layouts.default')
 

@section('stylesheet')
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/vendor/no-uislider.css') !!}">
  
@endsection

@section('content')
<div class="clearfix">
    <div class="main-contents settings__page">
        <div class="page-title text-capitalize border-bottom-0">
            <h2 class="m-0">Settings</h2>
        </div>
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible ">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session()->has('success_msg'))
                <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
                    <strong>Success!</strong> {!! session()->get('success_msg') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {!! session()->forget('success_msg') !!}
                </div>
            @endif
            @if(session()->has('error_msg'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Warning!</strong> {!! session()->get('error_msg') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {!! session()->forget('error_msg') !!}
                </div>
            @endif
        <form id="setting-form" autocomplete="off" action="" method="post" enctype="multipart/form-data" data-min="{{ auth()->check()? auth()->user()->min_age : "" }}" data-max="{{ auth()->check() ? auth()->user()->max_age : ""}} ">
            {!! csrf_field() !!}
            <div class="row mr-1">
                <div class="col-md-12 col-sm-12 col-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="tab__main">
                            {{-- <h3 class="mb-2">Profile Settings</h3>  --}}
                                <ul class="tab__items">
                                    <li id="profile" class="tab__item" data-tab="tab-1">Profile Image</li>
                                    <li id="profile_details" class="tab__item " data-tab="tab-2">Profile Details</li>
                                    <li id="password_tab" class="tab__item " data-tab="tab-3">Password and  Security</li>
                                    <li id="location_tab" class="tab__item" data-tab="tab-4">Location</li>
                                    <li id="interest_tab" class="tab__item " data-tab="tab-5">Interest's</li>
                                    <li id="preferences_tab" class="tab__item " data-tab="tab-6">Search preferences</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="tab__content" id="tab-1">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 offset-md-3">
                                                <div class="register-upload-avatar">
                                                    <input type="hidden" id="x" value="" name="x">
                                                    <input type="hidden" id="y" value="" name="y">
                                                    <input type="hidden" id="w" value="" name="w">
                                                    <input type="hidden" id="h" value="" name="h">
                                                    <span class="clear-avatar">&times;</span>
                                                    <img id="register-upload-avatar" width="250" src="{!! avatar($user->avatar, $user->gender) !!}">
                                                </div>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input accept="image/*" type="file" class="custom-file-input" name="avatar" id="register-avatar" aria-describedby="register-avatar">
                                                    <label class="custom-file-label-setting" for="register-avatar">Add Image</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center pt-6">
                                    <button class="btn btn-primary btn-block"   type="submit">Save Image</button>
                                </div>
                            </div>
                            <div class="tab__content " id="tab-2">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-12 ">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input class="form-control second bg-white" name="firstname" value="{!! $user->firstname !!}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input class="form-control second bg-white" name="lastname" value="{!! $user->lastname !!}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control second bg-white" readonly value="{!! $user->email !!}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input class="form-control second bg-white" autocomplete="off"  value="{!! $user->username !!}"  name="username" id="register-setting-username">
                                                <div class="username-error"></div>
                                                <div class="loader"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Birthday</label>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-3 col-3">
                                                    <select autocomplete="off" class="form-control second bg-white" name="day">
                                                        @for($i=1;$i <32; $i++)
                                                            <option{!!  (date('j', strtotime($user->birthday)) == $i) ? ' selected="selected"': '' !!} value="{!! strlen($i) == 1 ? '0'.$i:$i !!}" >{!! $i !!}</option>
                                                        @endfor
                                                    </select>
                                                    <i class="fa fa-chevron-down"></i>
                                                </div>
                                                <div class="col-md-4 col-sm-5 col-5">
                                                    <select autocomplete="off" class="form-control second bg-white" name="month">
                                                        @foreach(months() as $key=>$month)
                                                            <option{!!  date('n', strtotime($user->birthday)) == $key+1 ? ' selected': '' !!} value="{!! strlen($key+1) == 1?'0'.($key+1):$key+1 !!}">{!! $month !!}</option>
                                                        @endforeach
                                                    </select>
                                                    <i class="fa fa-chevron-down"></i>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <select autocomplete="off" class="form-control second bg-white" name="year">
                                                        @for($i=date('Y')-10;$i >= 1920; $i--)
                                                            <option{!! date('Y', strtotime($user->birthday)) == $i? ' selected':'' !!} value="{!! $i !!}">{!! $i !!}</option>
                                                        @endfor
                                                    </select>
                                                    <i class="fa fa-chevron-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control second bg-white" name="gender" id="gender">
                                                <option value="">Select gender</option>
                                                <option value="1" {!! $user->gender === 1?' selected':'' !!}>Male</option>
                                                <option value="2"{!! $user->gender === 2?' selected':'' !!}>Female</option>
                                            </select>
                                            <i class="fa fa-chevron-down"></i>
                                            <div class="gender-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Preference</label>
                                            <select class="form-control second bg-white" name="preference" id="preference" > 
                                                <option value="1" {!! $user->preference === 1?' selected':'' !!}>Male</option>
                                                <option value="2"{!! $user->preference === 2?' selected':'' !!}>Female</option>
                                                <option value="3"{!! $user->preference === 3?' selected':'' !!}>Male & Female</option>
                                            </select>
                                            <i class="fa fa-chevron-down"></i>
                                            <div class="preference-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>About Me</label>
                                            <textarea rows="3" style="box-shadow: none" name="about" class="form-control bg-white">{!! $user->about !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center pt-3">
                                    <button class="btn btn-primary btn-block" id="tab-2-profile"   type="submit">Update Profile</button>
                                </div>
                            </div>
                            <div class="tab__content " id="tab-3">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Old Password</label>
                                            <input autocomplete="off" class="form-control second bg-white" id="register-password-old" name="old-password" type="password">
                                            <div class="old-password-error"></div>
                                            <div class="loader"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input autocomplete="off" class="form-control second bg-white" disabled id="register-password" name="password" type="password">
                                            <div class="password-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Re-type Password</label>
                                            <input autocomplete="off" class="form-control second bg-white" disabled id="register-password-confirm" name="c-password" type="password">
                                            <div class="c-password-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center pt-3">
                                    <button class="btn btn-primary btn-block" id="tab-3-password" disabled   type="submit">Update Profile</button>
                                </div>
                            </div>
                            <div class="tab__content" id="tab-4">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input id="register-address" class="form-control second bg-white" name="address" value="{!! $user->address !!}">
                                            <input type="hidden" value="{!! $user->lat !!}" name="lat" id="register-lat">
                                            <input type="hidden" value="{!! $user->lng !!}" name="lng" id="register-lng">
                                            <div class="address-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Country</label>
                                            <select class="form-control second bg-white" name="country"  id="register-country">
                                                <option value="">Country</option>
                                                @foreach(countries() as $key=>$val)
                                                    <option{!! ($user->country == $key)?' selected':'' !!} value="{!! $key !!}">{!! $val !!}</option>
                                                @endforeach
                                            </select>
                                            <i class="fa fa-chevron-down"></i>
                                            <div class="country-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center pt-3">
                                    <button class="btn btn-primary btn-block"  id="tab-4-interest"  type="submit">Update Profile</button>
                                </div>
                            </div>
                            <div class="tab__content " id="tab-5">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="hidden" name="interests" value="" id="register-interests-input" >
                                            <h3 class="text-center interest_heading">Please choose some basic interest's</h3>
                                            <div class="d-flex justify-content-center">
                                                <input type="text" id="search_interest" placeholder="Type here to search for interest's" class="custom__search_interest">
                                            </div>
                                            <div class="selected__interest"></div>
                                            <div id="registered_interest" class="search_interest_available  mt-2"></div>
                                            <div class="loader d-flex justify-content-center"></div>
                                            <div class="interest-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center pt-3">
                                    <button class="btn btn-primary btn-block" id="tab-5-interest" type="submit">Update Profile</button>
                                </div>
                            </div>
                            <div class="tab__content" id="tab-6">
                                <div class="row">
                                    <div class="col-lg-6 offset-lg-3"> 
                                        <h3 class="title__range">Show me users between</h3> 
                                        <div class="range_slider_main">
                                            <div class="output__range slider-labels">
                                                <div>
                                                    <strong>Min age:</strong> <span id="slider-range-value1"></span>
                                                </div>
                                                <div>
                                                    <strong>Max age:</strong> <span id="slider-range-value2"></span>
                                                </div> 
                                            </div>
                                            <div id="slider-range"></div>
                                        <input type="hidden" name="min-age" id="min-value" value="">
                                        <input type="hidden" name="max-age" id="max-value" value="">
                                        </div>
                                    </div>
                                </div>   
                                <div class="row mt-5">
                                    <div class="col-md-12 col-sm-12 col-12"> 
                                    <div class="filter mb-5 ">
                                        <div class="location__main">
                                            Location <i class="fa fa-location-arrow" id="location__icon" aria-hidden="true"></i> 
                                        </div>
                                        <div class="location__search" style="width: 50%">
                                            <div class="w-100 h-100 d-flex justify-content-between align-items-center p-2">
                                            <input class="range" type="range" min="0" max="10000" value="{{$user->distance ? $user->distance : 0}}" step="2" onmousemove="rangevalue1.value=value" /> 
                                            <div class="output"><output id="rangevalue1"></output> Miles</div>
                                            <input type="hidden" name="distance" id="distance" value="{{ $user->distance }}">
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div> 
                                <div class="form-group text-center pt-3">
                                    <button class="btn btn-primary btn-block" id="tab-5-preference" type="submit">Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </form> 
    </div>
</div> 
@endsection
@section('javascript')
<script src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_PLACE_API','AIzaSyBjVRkL8MOLaVd-fjloQguTIQDLAAzA4w0') !!}&libraries=places&callback=initMap" async defer></script>
<script src="{!! url('assets/js/vendor/no-uislider.js') !!}"></script>
<script src="{!! url('assets/js/setting.js') !!}"></script> 
@endsection