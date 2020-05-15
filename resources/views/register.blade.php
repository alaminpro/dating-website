@extends('layouts.welcome')
<?php
$seo_social_image = setting('social_image');
?>
<?php
$seo_website_title = setting('website_title');
$seo_website_description = setting('website_description');
?>
@section('page_title')
    {{ "Register | DateV2" }}
@endsection
@section('page_description')
    {!! isset($seo_description) ? $seo_description.','.$seo_website_description : $seo_website_description !!}
@endsection
@section('social_image')
    {!! isset($seo_image) ? $seo_image : url($seo_social_image) !!}
@endsection
@section('stylesheet')
<style>
 
    .set-image {
        width:100%;
        height:100%;
        margin:auto;
    }
    .btn-register {
        background:#f478c4;
        color:#ffffff;
    }
    .set-login {
        margin-top:5%;
    }
    .section-h1 {
        padding-top:40px;
        padding-bottom:10px;
        font-weight:700;
    }
    .section-summary {
        text-align:center;
        font-weight:bolder;
        margin-bottom:50px;
    }
    h2 {
        font-size:24px;
        font-weight:bolder;
    }
    .intro {
        background:white;
        padding-bottom:25px;
    }
    .pt-20 {
        padding-top:20px;
    }
    .hidden {
        display:none;
    }
    .step{
        display: none;
    }
    .active-step{
        display: block;
    }
    @media screen and (max-width:760px) {
        .welcome {
            min-height:550px;
        }
    }
    .step__heading{ 
        font-size: 24px; 
        font-weight: normal;
    }
    .interest_heading{
        color: rgb(50, 50, 50);
        font-size: 24px; 
        font-weight: normal;
    }
   
    .custom__search_interest{
        width: 100%;
        background: transparent;
        border: none; 
        border-bottom: 1px solid #c1c1c1; 
        text-align: center; 
        color: #f0f0f0;
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
        color: #ff007c;
        border-radius: 5px; 
        translate: .5s all ease;
        border: 1px solid #ff007c;
    }
    .interest__item:hover{
        background: #f2f2f2;
    }
    .interest__item_selected{
        position: relative;
        background: #ff007c;
        margin: 5px;
        padding: 10px; 
        color: #fff;
        border-radius: 5px; 
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
   
    .tab__area_main {
        margin-top: 20px;
    }
    .login__register_heading{
        font-size: 30px;
    }
    .already__member{
        margin-top: 10px; 
        display: flex;
        justify-content: center;
    }
    .already__member a{
       color: #ff007c;
       margin-left: 5px;
    }
    </style>
@endsection


@section('content')
<div class="overflow-hidden bg-white">
    <div class="container-fluid m-0 p-0">
        <div class="row">
            <div class="col-md-6 d-none d-md-block"> 
                <?php
                $home_background = setting('home_background');
                $home_background = $home_background ? url($home_background) : url('uploads/static/background.jpg');
            ?>
               <div class="login__sidebar__main" style="background: url('{{ $home_background }}')">
                <?php
                    $logo = setting('website_logo');
                    $logo = $logo ? url($logo) : url('assets/images/logo.png');
                ?>  
                <a href="/" class="logo__login_register"><img class="set-welcome-logo" src="{!! $logo !!}"></a>
               </div>
            </div>
            <div class="col-md-6">  
                <div class="d-md-none">
                    <?php
                        $logo = setting('website_logo');
                        $logo = $logo ? url($logo) : url('assets/images/logo.png');
                    ?>  
                    <a href="/" class="logo__login"><img class="set-welcome-logo" src="{!! $logo !!}"></a>
                </div>
                <div class="login__register_wrapper">
                    <h1 class="login__register_heading text-center">Register with us now!</h1>
                    <div class="register__step_main">
                        <div id="register__step_one" class="register__step step__active">
                            <i class="fas fa-check"></i>
                        </div>
                        <div id="bar__one" class="step__bar step__bar_active"></div>  
                        <div id="register__step_two" class="register__step"> 
                            <i class="fas fa-check"></i>
                        </div>
                        <div  id="bar__two" class="step__bar"></div>
                        <div id="register__step_three" class="register__step">
                            <i class="fas fa-check"></i>
                        </div>
                        <div id="bar__three"  class="step__bar"></div>
                        <div id="register__step_four" class="register__step">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="tab__area_main">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger text-center mt-2">{{$error}}</div>     
                            @endforeach
                           
                        @endif  
                        @if(session()->has('minimum_age'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {!! session()->get('minimum_age') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {!! session()->forget('minimum_age') !!}
                            </div>
                        @endif

                        <form id="step-form" autocomplete="off" action="{{route('register')}}" method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div  class="step step-1 active-step">
                                <div class="form-group">
                                    <label for="register-username"  class="font-weight-bold">Choose a cool username</label>
                                    <input class="login__register_form_control" type="text"  autocomplete="off"  name="username" id="register-username" placeholder="Username">
                                    <div class="username-error"></div>
                                    <div class="loader"></div>
                                </div>
                                <div class="form-group">
                                    <label  for="register-email"  class="font-weight-bold">What's your email?</label>
                                    <input class="login__register_form_control" type="email" autocomplete="off" name="email" id="register-email" placeholder="Email">
                                    <div class="email-error"></div>
                                    <div class="loader-email"></div>
                                </div>
                                <div class="form-group">
                                    <label  for="register-password" class="font-weight-bold">Password</label>
                                    <input class="login__register_form_control" name="password" type="password" id="register-password" placeholder="Password">
                                    <div class="password-error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="register-password-confirm"  class="font-weight-bold">Confirm Password</label>
                                    <input class="login__register_form_control" type="password" name="password_confirmation" type="password" id="register-password-confirm" placeholder="Confirm password">
                                    <div class="c-password-error"></div>
                                </div>
                                <div class="form-group d-flex justify-content-between mr-2 mt-4">
                                    @if(setting('social_login'))
                                    <div class="social__login_main"> 
                                        <p>Register with</p>
                                        <div class="social__login">
                                            <a href="{!! route('loginfacebook') !!}" class="btn-facebook"><i class="fab fa-facebook-f"></i></a>
                                            <a href="{!! route('logintwitter') !!}" class="btn-twitter"><i class="fab fa-twitter"></i></a>
                                        </div>
                                    </div>
                                    @endif
                                    <button id="step-btn-1" class="login__register_btn ml-4"  type="button">Next</button>
                                </div>
                            </div>
                            <div  class="step step-2"> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  for="register-gender"  class="font-weight-bold">You are a</label>
                                            <select class="form-control second" name="gender" id="register-gender">
                                                <option value="" selected>Select option</option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                            <i class="fa fa-chevron-down"></i>
                                            <div class="gender-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="register-preference" class="font-weight-bold">Seeking a</label>
                                            <select class="form-control second" name="preference" id="register-preference" >
                                                <option value="" selected>select option</option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                                <option value="3">Male & Female</option>
                                            </select>
                                            <i class="fa fa-chevron-down"></i>
                                            <div class="preference-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="font-weight-bold">When is your birthday?</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control second" name="day" id="register-day">
                                                <option value="">Day</option>
                                                @for($i=1;$i <32; $i++)
                                                    <option value="{!! strlen($i) == 1 ? '0'.$i:$i !!}">{!! $i !!}</option>
                                                @endfor
                                            </select>
                                            <i class="fa fa-chevron-down"></i>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control second" name="month" id="register-month">
                                                <option value="">Month</option>
                                                @foreach(months() as $key=>$month)
                                                    <option value="{!! strlen($key+1) == 1?'0'.($key+1):$key+1 !!}">{!! $month !!}</option>
                                                @endforeach
                                            </select>
                                            <i class="fa fa-chevron-down"></i>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control second" name="year" id="register-year">
                                                <option value="">Year</option>
                                                @for($i=date('Y')-10;$i >= 1920; $i--)
                                                    <option value="{!! $i !!}">{!! $i !!}</option>
                                                @endfor
                                            </select>
                                            <i class="fa fa-chevron-down"></i>
                                        </div>
                                        <div class="date-error pl-3"></div>
                                    </div>
                                </div>
                                <h2 class="step__heading mb-2">Where are you located in the world?</h2>
                                <div class="form-group">
                                    <label  for="register-address" class="font-weight-bold">Address</label>
                                    <input class="form-control second" name="address" id="register-address">
                                    <input type="hidden" value="{!! $geoip['lat'] !!}" name="lat" id="register-lat">
                                    <input type="hidden" value="{!! $geoip['lng'] !!}" name="lng" id="register-lng">
                                    <div class="address-error"></div>
                                </div>
                                <div class="form-group">
                                    <label  for="register-country" class="font-weight-bold">Country</label>
                                    <select class="form-control second" name="country" id="register-country" >
                                        <option value="">Country</option>
                                        @foreach(countries() as $key=>$val)
                                            <option{!! ($geoip['iso_code'] == $key)?' selected':'' !!} value="{!! $key !!}">{!! $val !!}</option>
                                        @endforeach
                                    </select>
                                    <i class="fa fa-chevron-down"></i>
                                    <div class="country-error"></div>
                                </div>
                                <div class="form-group d-flex justify-content-between mr-2 mt-4">
                                    <button id="step-back-1" class="login__register_btn btn__blank mr-3"  type="button">Previews</button>
                                    <button id="step-btn-2" class="login__register_btn"  type="button">Next</button>
                                </div>
                            </div>
                            <div  class="step step-3  "> 
                                <div class="form-group">
                                    <input type="hidden" name="interests" value="" id="register-interests-input" >
                                    <h3 class="interest_heading mb-2">Please choose some basic interest's</h3> 
                                    <div>
                                        <label  for="search_interest" class="font-weight-bold">Type here to search for interest's</label>
                                        <input type="text" id="search_interest"  class="form-control second" placeholder="Photography, Gaming">
                                    </div>
                                    <div class="selected__interest"></div>
                                    <div id="registered_interest" class="search_interest_available  mt-2"></div>
                                    <div class="loader d-flex justify-content-center"></div> 
                                    <div class="interest-error"></div>
                                </div>
                                <h2 class="step__heading mb-2 text-dark font-weight-normal">Upload your best photo!</h2>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="register-upload-avatar m-0">
                                            <input type="hidden" id="x" value="" name="x">
                                            <input type="hidden" id="y" value="" name="y">
                                            <input type="hidden" id="w" value="" name="w">
                                            <input type="hidden" id="h" value="" name="h">
                                            <span class="clear-avatar">&times;</span>
                                            <img id="register-upload-avatar" src="{!! url('assets/images/1.jpg') !!}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 d-flex align-items-center">
                                        <div class="form-group">
                                           <h5 class="text-dark">Upload Profile Photo</h5>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input accept="image/*" type="file" class="custom-file-input" name="avatar" id="register-avatar" aria-describedby="register-avatar">
                                                    <label class="custom-file-label border" for="register-avatar">Choose file</label>
                                                    <div class="avater-error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="form-group d-flex justify-content-between  mr-2 mt-4">
                                    <button id="step-back-2" class="login__register_btn btn__blank  mr-3"  type="button">Previews</button>
                                    <button id="step-btn-3" class="login__register_btn"  type="button">Next</button>
                                </div>
                            </div>
                            <div  class="step step-4 "> 
                                <div class="d-flex justify-content-center flex-column align-items-center">
                                 
                                    <div class="final__icon"> 
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <p class="register__final text-center">Finally! Tell everyone a little bout you!</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">About Me</label>
                                    <textarea class="form-control second" rows="4" name="about"></textarea>
                                    <p class="font-weight-bold mb-0 mt-2">Please include important keywords example. </p>
                                    <p class="helper">Shy, Outgoing, Spontaneous, Fun, Love to travel or home body etc.</p>
                                </div>
                                <div class="form-group d-flex justify-content-between mr-2 mt-5">
                                    <button id="step-back-3" class="login__register_btn btn__blank  mr-3"  type="button">Previews</button>
                                    <button class="login__register_btn"  type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    <p class="already__member">Already  a member? <a class="font-weight-bold" href="{{ route('home') }}">Login</a></p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_PLACE_API','AIzaSyBjVRkL8MOLaVd-fjloQguTIQDLAAzA4w0') !!}&libraries=places&callback=initMap" async defer></script>
    <script>
      var uploadedImageURL = '{!! url('assets/images/1.jpg') !!}';
        jQuery(document).ready(function ($) {
            var token = $('meta[name=csrf_token]').attr('content');
 
            // start coding for username
            function isValidEmail(email) {
                var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
                return pattern.test(email);
            };
           
            var register__step_one = $('#register__step_one');
            var register__step_two = $('#register__step_two');
            var register__step_three = $('#register__step_three');
            var register__step_four = $('#register__step_four');
            var bar__one = $('#bar__one');
            var bar__two = $('#bar__two');
            var bar__three = $('#bar__three');
            // coding for password and confirm password
            var password =  $("#register-password");
            var c_password =  $("#register-password-confirm");
            var password_error = $('.password-error');
            var c_password_error = $('.c-password-error'); 
            $('#step-btn-1').on('click',function(){
               var username =  $("#register-username").val();
               var email =  $("#register-email").val();
                if(username == ''){
                    $('.username-error').html('<div class="text-danger">OPS!  Username is required!</div>');
                }else if(username.trim().length <= 5){
                    $('.username-error').empty();
                    $('.username-error').html('<div class="text-danger">Please enter at least 6 charecter!</div>');
                } 
                
                if(email == ''){
                    $('.email-error').html('<div class="text-danger">OPS!  Email is required!</div>');
                }else if(!isValidEmail(email)){
                    $('.email-error').empty();
                    $('.email-error').html('<div class="text-danger">Please enter valid email address!</div>');
                } 

                if(password.val() == ''){
                    password_error.html('<div class="text-danger">OPS!  Password is required!</div>');
                }
                if(c_password.val() == ''){ 
                    c_password_error.html('<div class="text-danger">OPS! Confirm Password is required!</div>');
                }
                if(password.val() != c_password.val()){
                    c_password_error.html('<div class="text-danger">OPS! Confirm Password does not match!</div>');
                }else{
                    if(username != '' && email != '' && password.val() !='' &&  c_password.val() != ''){
                        password_error.empty(); 
                        $('.username-error').empty();
                        $('.email-error').empty();
                        c_password_error.empty();
                        $('.step-1').removeClass('active-step');
                        $('.step-2').addClass('active-step'); 
                        bar__one.addClass('step__bar_complete')
                        bar__two.addClass('step__bar_active')
                        register__step_two.addClass('step__active')
                    }
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

            //start coding for gender and preference
            var gender = $('#register-gender')
            var preference = $('#register-preference')
            var gender_error = $('.gender-error')
            var preference_error = $('.preference-error')
            gender.on('change',function (e) {
                if($(this).val() == ''){
                    gender_error.html('<div class="text-danger">OPS!  Gender is required!</div>');
                }else{
                    gender_error.empty();
                }
            })
            preference.on('change',function (e) {
                if($(this).val() == ''){
                    preference_error.html('<div class="text-danger">OPS! Perference is required!</div>');
                }else{
                    preference_error.empty();
                }
            }) 
 
             //start coding for day month year
            var day = $('#register-day') 
            var month = $('#register-month') 
            var year = $('#register-year') 
            var date_error = $('.date-error') 
            day.on('change',function (e) {
                if($(this).val() == ''){
                    date_error.html('<div class="text-danger">OPS! All field is required!</div>');
                }else{
                    date_error.empty();
                }
            }) 
            month.on('change',function (e) {
                if($(this).val() == ''){
                    date_error.html('<div class="text-danger">OPS! All field is required!</div>');
                }else{
                    date_error.empty();
                }
            }) 
            year.on('change',function (e) {
                if($(this).val() == ''){
                    date_error.html('<div class="text-danger">OPS! All field is required!</div>');
                }else{
                    date_error.empty();
                }
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

            $('#step-btn-2').on('click',function(){  
                if(gender.val() == ''){
                    gender_error.html('<div class="text-danger">OPS!  Gender is required!</div>');
                }
                if(preference.val() == ''){ 
                    preference_error.html('<div class="text-danger">OPS! Perference is required!</div>');
                }
                if(preference.val() != '' && gender.val() != ''){ 
                    gender_error.empty();
                    preference_error.empty();
                    $('.step-4').removeClass('active-step');
                    $('.step-5').addClass('active-step');
                    
                }
                if(day.val() != '' && month.val() != '' && year.val() != ''){ 
                    date_error.empty();  
                }else{
                    date_error.html('<div class="text-danger">OPS! All field is required!</div>');
                }
                
                if(address.val() == ''){
                    address_error.html('<div class="text-danger">OPS! Address field is required!</div>');
                }
                if(country.val() == ''){ 
                    country_error.html('<div class="text-danger">OPS! Country is required!</div>');
                }
                if(preference.val() != '' && gender.val() != '' && country.val() != '' && address.val() != '' && day.val() != '' && month.val() != '' && year.val() != ''){ 
                    address_error.empty(); 
                    country_error.empty(); 
                    $('.step-2').removeClass('active-step');
                    $('.step-3').addClass('active-step');
                         bar__two.addClass('step__bar_complete')
                        bar__three.addClass('step__bar_active')
                        register__step_three.addClass('step__active')
                }
            })


            $('#step-back-1').on('click',function(){ 
                $('.step-1').addClass('active-step');
                $('.step-2').removeClass('active-step');
                bar__one.removeClass('step__bar_complete')
                bar__two.removeClass('step__bar_active')
                register__step_two.removeClass('step__active')
            }) 
 
            $('#step-back-2').on('click',function(){ 
                $('.step-2').addClass('active-step');
                $('.step-3').removeClass('active-step');
                bar__two.removeClass('step__bar_complete')
                bar__three.removeClass('step__bar_active')
                register__step_three.removeClass('step__active')
            }) 
            $('#step-back-3').on('click',function(){ 
                $('.step-3').addClass('active-step');
                $('.step-4').removeClass('active-step');
                bar__three.removeClass('step__bar_complete') 
                register__step_four.removeClass('step__active') 
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
                                setTimeout(() => { 
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
                                }, 100);
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
            $('#step-btn-3').on('click',function(){    
                if(interests.val() != ''){
                    $('.step-3').removeClass('active-step');
                    $('.step-4').addClass('active-step');
                    bar__three.addClass('step__bar_complete') 
                    register__step_four.addClass('step__active')
                }else{ 
                    interest_error.html('<div class="text-danger">OPS! Interest is required!</div>');
                }
                  
            })
          
        });
    </script>
@endsection