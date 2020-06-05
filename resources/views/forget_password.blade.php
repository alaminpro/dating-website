@extends('layouts.default')
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
 
<div class="overflow-hidden bg-white">
    <div class="container-fluid m-0 p-0">
        <div class="row" style="height: 82vh">
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
            <div class="col-md-6 ">  
                <div class="d-md-none w-100">
                    <?php
                        $logo = setting('website_logo');
                        $logo = $logo ? url($logo) : url('assets/images/logo.png');
                    ?>  
                    <a href="/" class="logo__login "><img class="set-welcome-logo" src="{!! $logo !!}"></a>
                </div>
                <div class="login__register_wrapper d-flex flex-column justify-content-center">
                    <h1 class="login__register_heading">Forgot your password?</h1>
                    <h3 class="login__register_sub_heading">No worries! Simply enter your email below and we will send you instructions to help you setup a new password</h3>
                      <hr>
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
                                    <input type="email" class="login__register_form_control" placeholder="Enter email" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <button class="login__register_btn d-block" type="submit">Submit</button>
                                </div>
                            </form>  
                </div>
            </div>
        </div> 
    </div> 
</div>
@endsection
