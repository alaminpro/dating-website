@extends('layouts.page')

@section('stylesheet')
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/no-uislider.css') !!}">
    <style>
      .tab__main {
            background: #fff;
            padding: 15px 0px;
            border-radius: 10px;
            margin-bottom: 120px;
            position: sticky;
            top: 20px;
        }
        .tab__main h3 {
            color: #222;
            font-size: 24px;
            padding: 10px 15px;
        }
        .tab__items{
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .tab__item:first-child {
            border-top: 1px solid #e8e8e8;
        }
        .tab__item:last-child {
            border-bottom: none;
        }
        .tab__item {
            border-bottom: 1px solid #e8e8e8;
            padding: 20px 15px;
            cursor: pointer;
        }
        .tab__active {
            background: #f0f0f0;
        }
        .tab__content{
			display: none;
			padding: 15px;
		}
        .tab__content.current{
			display: inherit;
		}
        .user-setting{
            padding-bottom: 0;
        }
        .custom-file-label::after{
            position: relative;
            display: none;
        }
        .custom-file-label-setting {
                height: auto;
                padding: 16px 50px;
                text-align: center;
                background-color: #5692ff;
                color: white;
                display: inline-block;
                margin-top: 50px;
                margin-right: 5px;
                cursor: pointer;
            }
            .input-group > .custom-file {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }
        .interest_heading {
            color: #686868;
            font-size: 26px;
            margin-bottom: 25px;
        }
        .step__heading{ 
            font-size: 30px; 
        }
        .custom__search_interest{
            width: 100%;
            background: transparent;
            border: none; 
            border-bottom: 1px solid #c1c1c1; 
            text-align: center; 
            color: #4d4d4d;
            margin-bottom: 10px;
        }
        .search_interest_available {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .selected__interest {
            display: flex;
            flex-wrap: wrap;  
        }
        .interest__item { 
            background: white;
            margin: 5px;
            padding: 10px;
            cursor: pointer;
            color: #5e5e5e;
            border-radius: 5px;
            box-shadow: 0px 2px 5px -1px #d2d2d2;
            translate: .5s all ease;
        }
        .interest__item:hover{
            background: #f2f2f2;
        }
        .interest__item_selected{
            position: relative;
            background: white;
            margin: 5px;
            padding: 10px; 
            color: #5e5e5e;
            border-radius: 5px;
            box-shadow: 0px 2px 5px -1px #d2d2d2; 
        }
        .cross__interest_btn{
            position: absolute;
        }
        .cross__interest_btn {
            position: absolute;
            right: -5px;
            top: -5px;
            background: #1c1c1c;
            padding: 5px;
            border-radius: 50px;
            width: 20px;
            height: 20px;
            font-size: 11px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        .cross__interest_btn:hover{
            background: #ff4f4f;
        }
        .location__search{
            right: 50%;
            transform: translateX(50%);
        }
        h3.title__range {
            font-size: 22px;
            text-align: center;
        }
    </style>
@endsection
@section('javascript')
    <script src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_PLACE_API','AIzaSyBjVRkL8MOLaVd-fjloQguTIQDLAAzA4w0') !!}&libraries=places&callback=initMap" async defer></script>
@endsection
@section('content')
<div class="user-setting mt-2 pl-3">
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
        <div class="alert alert-success alert-dismissible fade show" role="alert">
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
    <form id="setting-form" autocomplete="off" action="" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="row mr-1">
            <div class="col-md-12 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="tab__main">
                            <h3 class="mb-2">Profile Settings</h3>
                            <ul class="tab__items">
                                <li class="tab__item tab__active" data-tab="tab-1">Image Upload</li>
                                <li class="tab__item " data-tab="tab-2">Profile Details</li>
                                <li class="tab__item " data-tab="tab-3">Password and  Security</li>
                                <li class="tab__item" data-tab="tab-4">Location</li>
                                <li class="tab__item " data-tab="tab-5">Interest's</li>
                                <li class="tab__item " data-tab="tab-6">Search preferences</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab__content current" id="tab-1">
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
                                                <label class="custom-file-label-setting" for="register-avatar">upload</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center pt-3">
                                <button class="btn btn-primary btn-block"   type="submit">Update Profile</button>
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
                                            <option value="">Select preference</option>
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
                                    <div class="location__search">
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
@include('partials.footer')
<script src="{!! url('assets/js/no-uislider.js') !!}"></script>
<script>
    $(document).ready(function() {
    $('.noUi-handle').on('click', function() {
        $(this).width(50);
    });
    var rangeSlider = document.getElementById('slider-range');
    var start = [];
    var min = '{{ $user->min_age }}';
    var max = '{{ $user->max_age }}';
    if(min != '' && max != ''){
        start = [min, max];
    }else{
        start = [18, 90]
    }
    noUiSlider.create(rangeSlider, {
        start: start,
        step: 1,
        range: {
            'min': [18],
            'max': [90]
        }, 
        connect: true,
        format: wNumb({
            decimals: 0
        }),
    });
    
        // Set visual min and max values and also update value hidden form inputs
        rangeSlider.noUiSlider.on('update', function(values, handle) {
            document.getElementById('slider-range-value1').innerHTML = values[0];
            document.getElementById('slider-range-value2').innerHTML = values[1];  
            var minVal = $('#min-value');
            var maxVal = $('#max-value'); 
            minVal.val(values[0]) 
            maxVal.val(values[1]) 
        });
    });

    $('#location__icon').click(function(){
            $('.location__search').toggle();
        });
    $('.range').change(function(){
        $('#distance').val($(this).val())
    })



   var uploadedImageURL = '{!! avatar($user->avatar, $user->gender) !!}'; 
   $(document).ready(function(){
    var token = $('meta[name=csrf_token]').attr('content');

	$('ul.tab__items li').click(function(){
        var tab_id = $(this).attr('data-tab');

		$('ul.tab__items li.tab__item').removeClass('tab__active');
		$('.tab__content').removeClass('current');

		$(this).addClass('tab__active');
		$("#"+tab_id).addClass('current');
    })
    var loader = $('.loader');
    var alert = $('.username-error');
    $('#register-setting-username').on('keyup',function (e) {
        var username = $(this).val();
        loader.empty() 
        alert.empty()  
        if(username != ''){
            if(username.trim().length >= 6){
                alert.empty()  
                $.ajax({
                    url: ajax_url,
                    beforeSend: function(){ 
                        $('<div class="lds-ellipsis" style="height: 40px; margin-top: -20px;"></div>').html('<div></div><div></div><div></div><div></div>').appendTo(loader);
                        alert.empty()  
                    },
                    data: {action: 'check_username_setting', username: username, _token: token},
                    dataType: 'JSON',
                    type: 'POST',
                    success: function (res) { 
                        alert.empty()  
                        if(res.status == 'error'){  
                            $('#tab-2-profile').attr( "disabled", true )
                            $('<div class="text-danger"></div>').html('Username already exist! Try again.').appendTo(alert);
                        }
                        else if(res.status == 'success'){  
                            $('#tab-2-profile').removeAttr( "disabled" ) 
                            $('<div class="text-success"></div>').html('Great! You\'r Choose good username.').appendTo(alert);
                        }
                        else if(res.status == 'you'){ 
                            $('#tab-2-profile').removeAttr( "disabled" ) 
                            $('<div class="text-success"></div>').html('Your current username!').appendTo(alert);
                        }
                    },
                    complete: function(){
                        loader.empty();
                    }
                });
            }else{
                $('<div class="text-danger"></div>').html('Please enter at least 6 charecter!').appendTo(alert);
            }
        }else{
            loader.empty() 
            alert.empty()  
        }
    });
            var password =  $("#register-password");
            var c_password =  $("#register-password-confirm");
            var old_password =  $("#register-password-old");
            var password_error = $('.password-error');
            var c_password_error = $('.c-password-error');
            var old_password_error = $('.old-password-error');
            var loader = $('.loader');
            old_password.on('keyup',function(){
                var old_password =  $(this).val();
                loader.empty() 
                if(old_password.length >= 6){ 
                        old_password_error.empty()  
                        $.ajax({
                            url: ajax_url,
                            beforeSend: function(){ 
                                $('<div class="lds-ellipsis" style="height: 40px; margin-top: -20px;"></div>').html('<div></div><div></div><div></div><div></div>').appendTo(loader);
                                old_password_error.empty()  
                            },
                            data: {action: 'check_password', password: old_password , _token: token},
                            dataType: 'JSON',
                            type: 'POST',
                            success: function (res) { 
                                old_password_error.empty()  
                                if(res.status == 'error'){    
                                    password.attr( "disabled", true )
                                    c_password.attr( "disabled",true)
                                    $('#tab-3-password').attr( "disabled", true )
                                    $('<div class="text-danger"></div>').html('Old password doesn\'t match!').appendTo(old_password_error);
                                }
                                else{ 
                                    password.removeAttr( "disabled" )
                                    c_password.removeAttr( "disabled" ) 
                                    $('#tab-3-password').removeAttr( "disabled" )
                                    $('<div class="text-success"></div>').html('Password match!').appendTo(old_password_error);
                                }
                            },
                            complete: function(){
                                loader.empty();
                            }
                        }); 
                }else{ 
                    old_password_error.empty()  
                    $('<div class="text-danger"></div>').html('Please enter at least 6 charecter!').appendTo(old_password_error);
                }
            })



            password.on('keyup',function (e) {
                var password_val = $(this).val();
                if(password_val.length >= 6){
                    if(password_val != ''){
                        password_error.empty();
                    } else{
                        password_error.html('<div class="text-danger">OPS!  Password is required!</div>');
                    }
                }else{
                    password_error.empty();
                    password_error.html('<div class="text-danger">OPS!  Password must be 6 charecter!</div>');
                }
            });
            c_password.on('keyup',function (e) {
                var c_password_val = $(this).val();
                if(c_password_val.length >= 6){
                    if(c_password_val != ''){
                        password_error.empty();
                        if(password.val() != c_password_val){
                            c_password_error.html('<div class="text-danger">OPS! Confirm Password does not match!</div>');
                        }else{
                            c_password_error.empty();
                        }
                    } else{
                        c_password_error.html('<div class="text-danger">OPS! Confirm Password is required!</div>');
                    }
                }else{
                    c_password_error.empty();
                    c_password_error.html('<div class="text-danger">OPS! Confirm Password must be 6 charecter!</div>');
                    }
            }); 
            $('#tab-3-password').on('click',function(){ 
                var submited = true;
                if(old_password.val().length >= 6){ 
                    if(password.val() == ''){
                            password_error.html('<div class="text-danger">OPS!  Password is required!</div>');
                            return submited = false
                        }
                        if(c_password.val() == ''){ 
                            c_password_error.html('<div class="text-danger">OPS! Confirm Password is required!</div>');
                            return submited = false
                        }
                        if(password.val() != c_password.val()){
                            c_password_error.html('<div class="text-danger">OPS! Confirm Password does not match!</div>');
                            return submited = false
                        }
                }
                return submited;
            })
     
         //start coding for day month year
            var address = $('#register-address') 
            var country = $('#register-country') 
            var address_error = $('.address-error') 
            var country_error = $('.country-error') 
            address.on('keyup',function (e) {
                if($(this).val() == ''){
                    address_error.html('<div class="text-danger">OPS! Address field is required!</div>');
                }else{
                    address_error.empty();
                }
            }) 
            country.on('change',function (e) {
                if($(this).val() == ''){
                    country_error.html('<div class="text-danger">OPS! Country is required!</div>');
                }else{
                    country_error.empty();
                }
            })  
            $('#tab-4-interest').click(function(e){
               var submited = true;
               if(address.val() == ''){
                    address_error.html('<div class="text-danger">OPS! Address field is required!</div>');
                    submited= false
               }
               if(country.val() == ''){
                    country_error.html('<div class="text-danger">OPS! Country is required!</div>');
                    submited= false
               }
              return submited;
           })

         //start coding for day month year
            var gender = $('#gender') 
            var preference = $('#preference') 
            var gender_error = $('.gender-error') 
            var preference_error = $('.preference-error')  
            gender.on('change',function (e) {
                if($(this).val() == ''){
                    gender_error.html('<div class="text-danger">OPS! Gender is required!</div>');
                }else{
                    gender_error.empty();
                }
            })  
            preference.on('change',function (e) {
                if($(this).val() == ''){
                    preference_error.html('<div class="text-danger">OPS! Preference is required!</div>');
                }else{
                    preference_error.empty();
                }
            })  
            $('#tab-2-profile').click(function(e){
               var submited = true;
               if(gender.val() == ''){
                    gender_error.html('<div class="text-danger">OPS! Gender is required!</div>');
                    submited= false
               }
               if(preference.val() == ''){
                preference_error.html('<div class="text-danger">OPS! Preference is required!</div>');
                    submited= false
               }
              return submited;
           })




        // start coding for interest
            var selectedInterests = [];
            var selected_interest = $('.selected__interest');
            var interests = $('#register-interests-input');
            var search_interest = $('#search_interest');
            var interest_search_available = $('.search_interest_available');
            var loader = $('.loader');
            var interest_error = $('.interest-error');
                  
            search_interest.on('keyup',function (e) {
                var search = $(this).val();
                loader.empty()
                interest_error.empty();
                interest_search_available.empty()
                if(search != ''){
                interest_search_available.empty()
                        $.ajax({
                            url: ajax_url,
                            beforeSend: function(){
                                $('<div class="lds-ellipsis" style="height: 40px; margin-top: -20px;"></div>').html('<div></div><div></div><div></div><div></div>').appendTo(loader);
                                interest_search_available.empty()
                            },
                            data: {action: 'search_interest', search: search, _token: token},
                            dataType: 'JSON',
                            type: 'POST',
                            success: function (res) {
                                interest_search_available.empty() ;
                                if($.isEmptyObject(res.data)){
                                    $('<div class="text-center text-danger"></div>').html('Interest not found!').appendTo(interest_search_available);
                                }
                                if(res.status === 'success'){

                                    var results = res.data.filter(function(o1){
                                        return !selectedInterests.some(function(o2){
                                            return o1.id === o2.id;
                                        });
                                    })

                                    $.map(results, function(interest) {
                                            $('<div class="interest__item" data-id="'+interest.id+'"></div>').html('<i class="'+ interest.icon +'"></i>\
                                            <span>'+ interest.text +'</span>').appendTo(interest_search_available);
                                    })
                                } 
                            },
                            complete: function(){
                                loader.empty();
                            }
                        });
                }else{
                    loader.empty()
                    interest_search_available.empty()
                }
            });
            $.ajax({
                url: ajax_url, 
                data: {action: 'load_user_interest', id: '{{auth()->user()->id}}', _token: token},
                dataType: 'JSON',
                type: 'POST',
                context: this,
                success: function (res) {
                    if(res.status === 'success'){
                        interests.val(res.interest_id.join(',')) 
                        selectedInterests = res.interest;
                        $.map(res.interest, function(interest) { 
                                $('<div class="interest__item_selected"></div>').html('<i data-id="'+interest.id+'" class="cross__interest_btn fa fa-times"></i><i class="'+ interest.icon +'"></i>\
                                <span>'+ interest.text +'</span>').appendTo(selected_interest); 
                            })
                            $('.cross__interest_btn').click(function(){
                                interests.val('');
                                var id = $(this).data('id');
                                if(id){
                                    var deleteint = selectedInterests.find(interest => interest.id === id);
                                    var index = selectedInterests.indexOf(deleteint);
                                    selectedInterests.splice(index, 1);
                                    $(this).parent().remove();
                                    var removeOutput = selectedInterests.map(int => int.id)
                                    interests.val(removeOutput.join(','))
                                    $('<div class="interest__item" data-id="'+deleteint.id+'"></div>').html('<i class="'+ deleteint.icon +'"></i>\
                                    <span>'+ deleteint.text +'</span>').appendTo(interest_search_available);
                                }
                            })
                    } 
                }
            });
            $(document).off('click').on('click', '.interest__item', function() {
            var id = $(this).data('id');
                $.ajax({
                    url:ajax_url,
                    data: {action: 'interest_by_id', id: id, _token: token},
                    dataType: 'JSON',
                    type: 'POST',
                    context: this,
                    success: function (res) {
                        if(res.status === 'success'){
                            $(this).remove();
                            interest_error.empty();
                            selectedInterests.push(res.data)
                            }
                        setTimeout(() => {
                            var uniqueInterest = selectedInterests;
                            selectedInterests.filter(function(item){
                                    var i = uniqueInterest.findIndex(x => x.id == item.id);
                                        if(i <= -1){
                                            uniqueInterest.push(item);
                                        }
                                    return null;
                                });
                                if(!$.isEmptyObject(uniqueInterest)){
                                    selected_interest.empty();
                                    var outputs = [];
                                    $.map(uniqueInterest, function(output) {
                                        outputs.push(output.id)
                                        $('<div class="interest__item_selected"></div>').html('<i data-id="'+output.id+'" class="cross__interest_btn fa fa-times"></i><i class="'+ output.icon +'"></i>\
                                        <span>'+ output.text +'</span>').appendTo(selected_interest);

                                    })
                                        interests.val(outputs.join(','))
                                    $('.cross__interest_btn').click(function(){
                                        interests.val('');
                                        var id = $(this).data('id');
                                        if(id){
                                            var deleteint = selectedInterests.find(interest => interest.id === id);
                                            var index = selectedInterests.indexOf(deleteint);
                                            selectedInterests.splice(index, 1);
                                            $(this).parent().remove();
                                            var removeOutput = selectedInterests.map(int => int.id)
                                            interests.val(removeOutput.join(','))
                                            $('<div class="interest__item" data-id="'+deleteint.id+'"></div>').html('<i class="'+ deleteint.icon +'"></i>\
                                            <span>'+ deleteint.text +'</span>').appendTo(interest_search_available);
                                        }
                                    })
                                }

                        }, 50);
                    }
                })
            })   
           $('#tab-5-interest').click(function(e){
               var submited = true;
               if(interests.val() == ''){
                    interest_error.html('<div class="text-danger">OPS! Interest is required!</div>');
                    submited= false
               }
              return submited;
           })
})

</script>
@endsection
