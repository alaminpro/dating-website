@extends('layouts.welcome')
@section('content')
@section('stylesheet')
    <?php
    $register_background = setting('register_background');
    $register_background = $register_background ? url($register_background) : url('assets/images/bg.jpg');
    ?>
    <style>
        .register{
            background-image: url("{!! $register_background !!}");
            background-repeat: no-repeat;
            background-position: top left;
        }
    </style>
@endsection
<?php
$seo_social_image = setting('social_image');
?>
<style>
.welcome {
min-height:480px;
}
.set-image {
width:100%;
height:100%;
margin:auto;
}
.forgot-pass > p {
font-size:14px;
color:#ffffff;
}
.set-login {
margin-top:5%;
}
h2 {
font-size:24px;
font-weight:bolder;
}
.pt-20 {
 padding-top:20px;
}
@media screen and (max-width:760px) {
.welcome {
min-height:550px;
}
}
.forgot-pass, h1 {
color: whitesmoke;
font-size: 33px;
}
.form-group label {
color:#ffffff;
}
.btn-register {
background:#f478c4;
color:#ffffff;
}
.set-login {
margin-top:5%;
}
.intro {
background:white;
padding-bottom:25px;
}
.pt-20 {
 padding-top:20px;
}
.login_forms .form-control {
    min-height: calc(1.9em + .75rem + 5px);
    box-shadow: inset 0px -1px 1px -2px rgb(149, 149, 149);
    border-radius: 6px;
    font-size: 16px;
}
</style>
    <div class="register overflow-hidden">
        <div class="container h-100 position-relative">
          <!--  <span class="position-absolute circle-1"></span>
            <span class="position-absolute circle-2"></span> -->
            <div class="row h-100">
                <div class="col-md-6 d-none d-sm-block"><!--  pt-5 -->
                 <!--   <?php
                        $home_background = setting('home_background');
                        $home_background = $home_background ? url($home_background) : url('assets/images/couple.png');
                    ?>
                    <img class="set-image" src="{!! $home_background !!}"> -->
                </div>
                <div class="col-md-6">
                    <div class="row" class="set-login">
                        <div class="col-md-9 mx-auto pt-5"><span class="forgot-pass"><h1>Forgot your password?</h1>
<p>No worries! Simply enter your email below and we will send you instructions to help you setup a new password</p></span>
                          @if(Session::has('resetAlert'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Oops!</strong> {!! session()->get('resetAlert') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                                {{ session()->forget('resetAlert') }}
                            @endif
                          @if(Session::has('resetSuccess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                 {!! session()->get('resetSuccess') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                                {{ session()->forget('resetSuccess') }}
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
                            <form method="post" class="login_forms" action="{{ url('/checkEmail') }}">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" placeholder="Enter email" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
