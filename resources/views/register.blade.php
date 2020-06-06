@extends('layouts.default')
<!-- <?php
$seo_social_image = setting('social_image');
?> --> <!--
<?php
$seo_website_title = setting('website_title');
$seo_website_description = setting('website_description');
?> -->
@section('page_title')
    {{ "Register | DateV2" }}
@endsection
@section('page_description')
    {!! isset($seo_description) ? $seo_description.','.$seo_website_description : $seo_website_description !!}
@endsection
@section('social_image')
    {!! isset($seo_image) ? $seo_image : url($seo_social_image) !!}
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
                        <div id="bar__four"  class="step__bar"></div>
                        <div id="register__step_five" class="register__step">
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
                                <div class="form-group">
                                    <label  for="register-address" class="font-weight-bold">City</label>
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
                                    <button id="step-back-1" class="login__register_btn btn__blank mr-3"  type="button">Previous</button>
                                    <button id="step-btn-2" class="login__register_btn"  type="button">Next</button>
                                </div>
                            </div>
                            <div  class="step step-3  "> 
                                <div class="form-group">
                                    <input type="hidden" name="interests" value="" id="register-interests-input" >
                                    <h3 class="interest_heading mb-2">Please choose some basic interest's</h3> 
                                    <div>
                                        <label  for="search_interest" class="font-weight-bold">Type here to search for interest's</label>
                                        <input type="text" id="search_interest"  class="form-control second" placeholder="Photography, Gaming, Traveling etc">
                                    </div>
                                    <div class="selected__interest"></div>
                                    <div id="registered_interest" class="search_interest_available  mt-2"></div>
                                    <div class="loader d-flex justify-content-center"></div> 
                                    <div class="interest-error"></div>
                                </div>
                                <div class="form-group d-flex justify-content-between  mr-2 mt-4">
                                    <button id="step-back-2" class="login__register_btn btn__blank  mr-3"  type="button">Previous</button>
                                    <button id="step-btn-3" class="login__register_btn"  type="button">Next</button>
                                </div>
                            </div> 
                            <div  class="step step-4  ">   
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
                                           <h5 class="text-dark">Choose Image</h5>
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
                                    <button id="step-back-3" class="login__register_btn btn__blank  mr-3"  type="button">Previous</button>
                                    <button id="step-btn-4" class="login__register_btn"  type="button">Next</button>
                                </div>
                            </div>
                            <div  class="step step-5 "> 
                                <div class="d-flex justify-content-center flex-column align-items-center">
                                 <h6 class="register__final text-center">Finally! Tell everyone a little bout you!</h6>
                                    <div class="final__icon"> 
                                        <i class="fas fa-check"></i>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">About Me</label>
                                    <textarea class="form-control second" rows="4" name="about"></textarea>
                                    <p class="font-weight-bold mb-0 mt-2">Please include important keywords example. </p>
                                    <p class="helper">Outgoing, Spontaneous, Fun, Love to travel or home body, Shy etc.</p>
                                </div>
                                <div class="form-group d-flex justify-content-between mr-2 mt-5">
                                    <button id="step-back-4" class="login__register_btn btn__blank  mr-3"  type="button">Previous</button>
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
    <script src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_PLACE_API','AIzaSyBjVRkL8MOLaVd-fjloQguTIQDLAAzA4w0') !!}&libraries=places&callback=initMap" defer></script>
    <script>var uploadedImageURL = "{!! url('assets/images/1.jpg') !!}";</script> 
    <script src="{!! url('assets/js/vendor/cropper.min.js') !!}"></script>
    <script src="{!! url('assets/js/register.js') !!}"></script>  
@endsection