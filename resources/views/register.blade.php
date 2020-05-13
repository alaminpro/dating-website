@extends('layouts.welcome')
@section('content')
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
<style>

.form-group label {
    color:#ffffff;
}
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
.interest_heading{
    color: white;
    font-size: 30px;
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
	color: #5e5e5e;
	border-radius: 5px;
	box-shadow: 0px 2px 5px -1px #484848;
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
	box-shadow: 0px 2px 5px -1px #484848; 
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
.welcome{
    min-height: 470px;
} 
.tab__area_main {
	margin-top: 50px;
}
 
</style>
    <div class="welcome overflow-hidden">
        <div class="container position-relative">
            @if($errors->any())
                <div class="alert alert-danger text-center mt-2">{{$errors->first('errors')}}</div>
            @endif
            <div class="row"> 
                <div class="col-md-6 offset-md-3" >
                    <div class="row" class="set-login">
                        <div class="col-md-12 mx-auto pt-5 pb-5"> 
                            <div class="tab__area_main">
                                <form id="step-form" autocomplete="off" action="{{route('register')}}" method="post" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <div  class="step step-1 active-step">
                                        <h2 class="step__heading mb-4 text-light">Choose a cool username</h2>
                                        <div class="form-group"> 
                                            <input class="form-control second bg-mute custom_btn" autocomplete="off"  name="username" id="register-username">
                                            <div class="username-error"></div>
                                            <div class="loader"></div>
                                        </div>
                                        <div class="form-group"> 
                                            <button id="step-btn-1" class="btn btn-primary btn-block custom_btn"  type="button">Next</button>
                                        </div>
                                    </div>
                                    <div  class="step step-2">
                                        <h2 class="step__heading mb-4 text-light">What's your email?</h2>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control second bg-mute custom_btn" autocomplete="off" name="email" id="register-email">
                                            <div class="email-error"></div>
                                            <div class="loader"></div>
                                        </div>
                                        <div class="form-group d-flex">
                                             <button id="step-back-2" type="button" class="btn btn-success custom_btn mr-2">Previous</button>
                                            <button id="step-btn-2" class="btn btn-primary btn-block custom_btn"  type="button">Next</button>
                                        </div>
                                    </div>
                                    <div class="step step-3">
                                        <h2 class="step__heading mb-4 text-light">Let's create a strong password</h2>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control second bg-mute custom_btn" name="password" type="password" id="register-password" >
                                            <div class="password-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input class="form-control second bg-mute custom_btn" name="password_confirmation" type="password" id="register-password-confirm">
                                            <div class="c-password-error"></div>
                                        </div>
                                        <div class="form-group d-flex">
                                        <button id="step-back-3" type="button" class="btn btn-success custom_btn mr-2">Previous</button>
                                            <button id="step-btn-3" class="btn btn-primary btn-block custom_btn"  type="button">Next</button>
                                        </div>
                                    </div>
                                    <div class="step step-4"> 
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>You are a</label>
                                                    <select class="form-control second bg-mute custom_btn" name="gender" id="register-gender">
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
                                                    <label>Seeking a</label>
                                                    <select class="form-control second bg-mute custom_btn" name="preference" id="register-preference" >
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
                                        <div class="form-group d-flex">
                                        <button id="step-back-4" type="button" class="btn btn-success custom_btn mr-2">Previous</button>
                                            <button id="step-btn-4" class="btn btn-primary btn-block custom_btn"  type="button">Next</button>
                                        </div>
                                    </div>
                                    <div class="step step-5  ">
                                        <h2 class="step__heading mb-4 text-light">When is your birthday?</h2>
                                        <div class="form-group">
                                            <label>Birthday</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select class="form-control second bg-mute custom_btn" name="day" id="register-day">
                                                        <option value="">Day</option>
                                                        @for($i=1;$i <32; $i++)
                                                            <option value="{!! strlen($i) == 1 ? '0'.$i:$i !!}">{!! $i !!}</option>
                                                        @endfor
                                                    </select>
                                                    <i class="fa fa-chevron-down"></i>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control second bg-mute custom_btn" name="month" id="register-month">
                                                        <option value="">Month</option>
                                                        @foreach(months() as $key=>$month)
                                                            <option value="{!! strlen($key+1) == 1?'0'.($key+1):$key+1 !!}">{!! $month !!}</option>
                                                        @endforeach
                                                    </select>
                                                    <i class="fa fa-chevron-down"></i>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control second bg-mute custom_btn" name="year" id="register-year">
                                                        <option value="">Year</option>
                                                        @for($i=date('Y')-10;$i >= 1920; $i--)
                                                            <option value="{!! $i !!}">{!! $i !!}</option>
                                                        @endfor
                                                    </select>
                                                    <i class="fa fa-chevron-down"></i>
                                                </div>
                                                <div class="date-error d-flex justify-content-center mt-2 w-100"></div>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex">
                                            <button id="step-back-5" type="button" class="btn btn-success custom_btn mr-2">Previous</button>
                                             <button id="step-btn-5" class="btn btn-primary btn-block custom_btn"  type="button">Next</button>
                                        </div>
                                    </div>
                                    <div class="step step-6">
                                    <h2 class="step__heading mb-4 text-light">Where are you located in the world?</h2>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input class="form-control second bg-mute custom_btn" name="address" id="register-address">
                                            <input type="hidden" value="{!! $geoip['lat'] !!}" name="lat" id="register-lat">
                                            <input type="hidden" value="{!! $geoip['lng'] !!}" name="lng" id="register-lng">
                                            <div class="address-error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Country</label>
                                            <select class="form-control second bg-mute custom_btn" name="country" id="register-country" >
                                                <option value="">Country</option>
                                                @foreach(countries() as $key=>$val)
                                                    <option{!! ($geoip['iso_code'] == $key)?' selected':'' !!} value="{!! $key !!}">{!! $val !!}</option>
                                                @endforeach
                                            </select>
                                            <i class="fa fa-chevron-down"></i>
                                            <div class="country-error"></div>
                                        </div>
                                        <div class="form-group d-flex">
                                        <button id="step-back-6" type="button" class="btn btn-success custom_btn mr-2">Previous</button>
                                            <button id="step-btn-6" class="btn btn-primary btn-block custom_btn"  type="button">Next</button>
                                        </div>
                                    </div>
                                    <div class="step step-7 "> 
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
                                        <div class="form-group d-flex mt-3">
                                        <button id="step-back-7" type="button" class="btn btn-success custom_btn mr-2">Previous</button>
                                            <button id="step-btn-7" class="btn btn-primary btn-block custom_btn"  type="button">Next</button>
                                        </div>
                                    </div>
                                    <div class="step step-8">
                                    <h2 class="step__heading mb-4 text-light">Upload your best photo!</h2>
                                    <div class="row">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="form-group">
                                               <h4 class="text-light">Upload Profile Photo</h4>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input accept="image/*" type="file" class="custom-file-input" name="avatar" id="register-avatar" aria-describedby="register-avatar">
                                                        <label class="custom-file-label" for="register-avatar">Choose file</label>
                                                        <div class="avater-error"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="register-upload-avatar">
                                                <input type="hidden" id="x" value="" name="x">
                                                <input type="hidden" id="y" value="" name="y">
                                                <input type="hidden" id="w" value="" name="w">
                                                <input type="hidden" id="h" value="" name="h">
                                                <span class="clear-avatar">&times;</span>
                                                <img id="register-upload-avatar" src="{!! url('assets/images/1.jpg') !!}">
                                            </div>
                                        </div>
                                    </div>
                                        <div class="form-group d-flex">
                                        <button id="step-back-8" type="button" class="btn btn-success custom_btn mr-2">Previous</button>
                                            <button id="step-btn-8" class="btn btn-primary btn-block custom_btn"  type="button">Next</button>
                                        </div>
                                    </div>
                                    <div class="step step-9 ">
                                    <h2 class="step__heading mb-4 text-light">Finally! Tell everyone a little about you.</h2>
                                        <div class="form-group">
                                            <label>About Me</label>
                                            <textarea class="form-control second bg-mute custom_btn" rows="6" name="about"></textarea>
                                            <p class="font-weight-bold mb-0 mt-3 text-light">Please include important keywords example. </p>
                                            <p class="helper text-light">Shy, Outgoing, Spontaneous, Fun, Love to travel or home body etc.</p>
                                        </div>
                                        <div class="form-group d-flex">
                                            <button id="step-back-9" type="button" class="btn btn-success custom_btn mr-2">Previous</button>
                                            <button class="btn btn-primary btn-block custom_btn" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
 
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

            // $('#step-form').find('.step-1').first().addClass('active-step');
            var store_array = [];
            // start coding for username
            function isValidEmail(email) {
                var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
                return pattern.test(email);
            };

            $('#step-btn-1').on('click',function(){
               var username =  $("#register-username").val()
                if(username == ''){
                    $('.username-error').html('<div class="text-light">OPS!  Username is required!</div>');
                }else if(username.trim().length <= 5){
                    $('.username-error').empty();
                    $('.username-error').html('<div class="text-light">Please enter at least 6 charecter!</div>');
                }else{
                    $('.username-error').empty();
                    $('.step-1').removeClass('active-step');
                    $('.step-2').addClass('active-step');
                    store_array.push('step-1');
                }
            })
            $('#step-btn-2').on('click',function(){
               var email =  $("#register-email").val();
                if(email == ''){
                    $('.email-error').html('<div class="text-light">OPS!  Email is required!</div>');
                }else if(!isValidEmail(email)){
                    $('.email-error').empty();
                    $('.email-error').html('<div class="text-light">Please enter valid email address!</div>');
                }else{
                    $('.email-error').empty();
                    $('.step-2').removeClass('active-step');
                    $('.step-3').addClass('active-step');
                    store_array.push('step-2');
                }
            })
        
            $('#step-back-2').on('click',function(){ 
                    $('.step-2').removeClass('active-step');
                    $('.step-1').addClass('active-step');
            })
            // coding for password and confirm password
            var password =  $("#register-password");
            var c_password =  $("#register-password-confirm");
            var password_error = $('.password-error');
            var c_password_error = $('.c-password-error');
            password.on('keyup',function (e) {
                var password_val = $(this).val();
                if(password_val.length >= 6){
                    if(password_val != ''){
                        password_error.empty();
                    } else{
                        password_error.html('<div class="text-light">OPS!  Password is required!</div>');
                    }
                }else{
                    password_error.empty();
                    password_error.html('<div class="text-light">OPS!  Password must be 6 charecter!</div>');
                }
            });
            c_password.on('keyup',function (e) {
                var c_password_val = $(this).val();
                if(c_password_val.length >= 6){
                    if(c_password_val != ''){
                        password_error.empty();
                        if(password.val() != c_password_val){
                            c_password_error.html('<div class="text-light">OPS! Confirm Password does not match!</div>');
                        }else{
                            c_password_error.empty();
                        }
                    } else{
                        c_password_error.html('<div class="text-light">OPS! Confirm Password is required!</div>');
                    }
                }else{
                    c_password_error.empty();
                    c_password_error.html('<div class="text-light">OPS! Confirm Password must be 6 charecter!</div>');
                    }
            }); 
            $('#step-btn-3').on('click',function(){ 
                if(password.val() == ''){
                    password_error.html('<div class="text-light">OPS!  Password is required!</div>');
                }
                if(c_password.val() == ''){ 
                    c_password_error.html('<div class="text-light">OPS! Confirm Password is required!</div>');
                }
                if(password.val() != c_password.val()){
                    c_password_error.html('<div class="text-light">OPS! Confirm Password does not match!</div>');
                }else{
                    password_error.empty();
                    c_password_error.empty();
                    $('.step-3').removeClass('active-step');
                    $('.step-4').addClass('active-step');
                    store_array.push('step-3');
                }
            })
            $('#step-back-3').on('click',function(){ 
                    $('.step-3').removeClass('active-step');
                    $('.step-2').addClass('active-step');
            })
            //start coding for gender and preference
            var gender = $('#register-gender')
            var preference = $('#register-preference')
            var gender_error = $('.gender-error')
            var preference_error = $('.preference-error')
            gender.on('change',function (e) {
                if($(this).val() == ''){
                    gender_error.html('<div class="text-light">OPS!  Gender is required!</div>');
                }else{
                    gender_error.empty();
                }
            })
            preference.on('change',function (e) {
                if($(this).val() == ''){
                    preference_error.html('<div class="text-light">OPS! Perference is required!</div>');
                }else{
                    preference_error.empty();
                }
            }) 
            $('#step-btn-4').on('click',function(){  
                if(gender.val() == ''){
                    gender_error.html('<div class="text-light">OPS!  Gender is required!</div>');
                }
                if(preference.val() == ''){ 
                    preference_error.html('<div class="text-light">OPS! Perference is required!</div>');
                }
                if(preference.val() != '' && gender.val() != ''){ 
                    gender_error.empty();
                    preference_error.empty();
                    $('.step-4').removeClass('active-step');
                    $('.step-5').addClass('active-step');
                    store_array.push('step-4');
                }
            })
            $('#step-back-4').on('click',function(){ 
                    $('.step-4').removeClass('active-step');
                    $('.step-3').addClass('active-step');
            })
             //start coding for day month year
            var day = $('#register-day') 
            var month = $('#register-month') 
            var year = $('#register-year') 
            var date_error = $('.date-error') 
            day.on('change',function (e) {
                if($(this).val() == ''){
                    date_error.html('<div class="text-light">OPS! All field is required!</div>');
                }else{
                    date_error.empty();
                }
            }) 
            month.on('change',function (e) {
                if($(this).val() == ''){
                    date_error.html('<div class="text-light">OPS! All field is required!</div>');
                }else{
                    date_error.empty();
                }
            }) 
            year.on('change',function (e) {
                if($(this).val() == ''){
                    date_error.html('<div class="text-light">OPS! All field is required!</div>');
                }else{
                    date_error.empty();
                }
            }) 
            $('#step-btn-5').on('click',function(){   
                if(day.val() != '' && month.val() != '' && year.val() != ''){ 
                    date_error.empty(); 
                    $('.step-5').removeClass('active-step');
                    $('.step-6').addClass('active-step');
                    store_array.push('step-5');
                }else{
                    date_error.html('<div class="text-light">OPS! All field is required!</div>');
                }
            })
            $('#step-back-5').on('click',function(){ 
                    $('.step-5').removeClass('active-step');
                    $('.step-4').addClass('active-step');
            })
             //start coding for day month year
             var address = $('#register-address') 
            var country = $('#register-country') 
            var address_error = $('.address-error') 
            var country_error = $('.country-error') 
            address.on('keyup',function (e) {
                if($(this).val() == ''){
                    address_error.html('<div class="text-light">OPS! Address field is required!</div>');
                }else{
                    address_error.empty();
                }
            }) 
            country.on('change',function (e) {
                if($(this).val() == ''){
                    country_error.html('<div class="text-light">OPS! Country is required!</div>');
                }else{
                    country_error.empty();
                }
            }) 
            $('#step-btn-6').on('click',function(){   
                if(address.val() == ''){
                    address_error.html('<div class="text-light">OPS! Address field is required!</div>');
                }
                if(country.val() == ''){ 
                    country_error.html('<div class="text-light">OPS! Country is required!</div>');
                }
                if(country.val() != '' && address.val() != ''){ 
                    address_error.empty(); 
                    country_error.empty(); 
                    $('.step-6').removeClass('active-step');
                    $('.step-7').addClass('active-step');
                    store_array.push('step-6');
                }
            })
            $('#step-back-6').on('click',function(){ 
                    $('.step-6').removeClass('active-step');
                    $('.step-5').addClass('active-step');
            })
            $('#step-btn-8').on('click',function(){   
                    $('.step-8').removeClass('active-step');
                    $('.step-9').addClass('active-step');
                    store_array.push('step-8'); 
            }) 
            $('#step-back-7').on('click',function(){ 
                    $('.step-7').removeClass('active-step');
                    $('.step-6').addClass('active-step');
            })
            $('#step-back-8').on('click',function(){ 
                    $('.step-8').removeClass('active-step');
                    $('.step-7').addClass('active-step');
            })
            $('#step-back-9').on('click',function(){ 
                    $('.step-9').removeClass('active-step');
                    $('.step-8').addClass('active-step');
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
                                    $('<div class="text-center text-light"></div>').html('Interest not found!').appendTo(interest_search_available);
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
            $('#step-btn-7').on('click',function(){    
                if(interests.val() != ''){
                    $('.step-7').removeClass('active-step');
                    $('.step-8').addClass('active-step');
                    store_array.push('step-7'); 
                }else{ 
                    interest_error.html('<div class="text-light">OPS! Interest is required!</div>');
                }
                  
            })
          
        });
    </script>
@endsection