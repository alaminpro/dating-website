@extends('layouts.default')
@section('content')
<?php
$seo_social_image = setting('social_image');
?>
<?php
$seo_website_title = setting('website_title');
$seo_website_description = setting('website_description');
?>
@section('page_title')
    {{ "Home | Welcome to" }}
@endsection
@section('page_description')
    {!! isset($seo_description) ? $seo_description.','.$seo_website_description : $seo_website_description !!}
@endsection
@section('social_image')
    {!! isset($seo_image) ? $seo_image : url($seo_social_image) !!}
@endsection 
    <div class="overflow-hidden bg-white">
        <div class="container-fluid m-0 p-0">
            <div class="row hero-bg">
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
                        <h1 class="login__register_heading">Chat, flirt and Video Call Live Singles Nearby</h1>
                        <h2 class="login__register_sub_heading">See who you are taking to online before meeting them in person</h2>
                        <a href="{{ route('register') }}" class="login__register_btn register__margin">Register</a> 
                        <hr>
                        @if(session()->has('fail_login'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Warning!</strong> {!! session()->get('fail_login') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            {{ session()->forget('fail_login') }}
                        @endif
                        @if(Session::has('passwordSuccess'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                               {!! session()->get('passwordSuccess') !!}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                              {{ session()->forget('passwordSuccess') }}
                          @endif
                        @if($errors->any())
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        @foreach($error as $item)
                                            <li>{!! $item !!}</li>
                                        @endforeach
                                    @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                        @endif
                        <form method="post" class="login_form" action="">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="font-weight-bold">Username</label>
                                <input class="login__register_form_control" type="text" required name="username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Password</label>
                                <input class="login__register_form_control" type="password" required name="password" placeholder="Password">
                                <div class="remember__forgot">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                          <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                    <a href="{{url('forget-password')}}" class="forget__password">Forgot password ?</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="login__register_btn mt-3" type="submit">Login</button>
                            </div>
                        </form>
                     
                         
                        @if(setting('social_login'))
                        <div class="social__login_main"> 
                            <p>Register with</p>
                            <div class="social__login">
                                <a href="{!! route('loginfacebook') !!}" class="btn-facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="{!! route('logintwitter') !!}" class="btn-twitter"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div> 
        </div>
        <section style="margin-top: 20px;"> 
            <div class="container d-none d-lg-block" >
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-center">
                        <h2 class="pb-3">Your Solution to Online Video Dating</h2>
                        <p>Looking for the love of your life in a fun, new and safe way? At DateV2, your search will be over. Enjoy the benefits of online dating with the help of DateV2 in a hassle-free way. With our <b>Free Video Call</b> feature, you can instantly connect with thousands of singles online from all around the world.</p><p>Dating has changed in 2020. Now it's all at your fingertips from the comfort of your home or on the road. Our interactive approach to online dating allows you to meet new people one-on-one. So while you find the perfect partner online, you can maintain your anonymity, privacy and most of all, Your Safety.</p>
                    </div>
                    <div class="col-lg-6  d-flex justify-content-end">
                         <img src="{{ asset('uploads/static/landing_1.jpg') }}" width="100%" alt="landing image one">
                    </div>
                </div>
                <div class="row mt-2 mb-5">
                    <div class="col-lg-6">
                        <img src="{{ asset('uploads/static/landing_2.jpg') }}" width="100%" alt="landing image one"> 
                    </div>
                    <div class="col-lg-6  d-flex flex-column justify-content-center">
                        <h2 class="pb-3">Find the perfect match without any upfront cost</h2>
                        <p>Whether you want to make new friends, get a date, or even find the love of your life, DateV2 can turn everything around for you. Finding the right partner can be very detrimental and difficult. With video chat, you won't have to worry about spending your resources on a person you are not compatible with. Instead, you can first talk with the man or woman to ensure that the person suits you before jumping head first.</p>
                    </div>
                </div>
            </div>
            <div class="container d-block d-lg-none" >
                <div class="row justify-content-center pleft-1 pright-1"> 
                        <h2 class="pleft-1 pright-1">Your Solution to Online Video Dating</h2>
                        <img src="{{ asset('uploads/static/landing_1.jpg') }}" width="100%" alt="landing image one">
                        <p>Looking for the love of your life in a fun, new and safe way? At DateV2, your search will be over. Enjoy the benefits of online dating with the help of DateV2 in a hassle-free way. With our <b>Free Video Call</b> feature, you can instantly connect with thousands of singles online from all around the world.</p><p>Dating has changed in 2020. Now it's all at your fingertips from the comfort of your home or on the road. Our interactive approach to online dating allows you to meet new people one-on-one. So while you find the perfect partner online, you can maintain your anonymity, privacy and most of all, Your Safety.</p>
                 
                </div>
                <div class="row justify-content-center pleft-1 pright-1">  
                        <h2 class="pleft-1 pright-1">Find the perfect match without any upfront cost</h2>
                        <img src="{{ asset('uploads/static/landing_2.jpg') }}" width="100%" alt="landing image one"> 
                        <p>Whether you want to make new friends, get a date, or even find the love of your life, DateV2 can turn everything around for you. Finding the right partner can be very detrimental and difficult. With video chat, you won't have to worry about spending your resources on a person you are not compatible with. Instead, you can first talk with the man or woman to ensure that the person suits you before jumping head first.</p>
                 
                </div>
            </div>
        </section>
    </div>
@endsection

@section('intro')
 
@endsection
