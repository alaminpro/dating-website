@extends('layouts.welcome')
@section('content')
<?php
$seo_social_image = setting('social_image');
?>
<style>
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
.section-summary {
text-align:center;
font-weight:bolder;
margin-bottom:50px;
}
h2 {
font-size:24px;
font-weight:bolder;
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
    <div class="welcome overflow-hidden">
        <div class="container h-100 position-relative">
          <!--  <span class="position-absolute circle-1"></span>
            <span class="position-absolute circle-2"></span> -->
            <div class="row h-100">
                <div class="col-md-6 d-none d-sm-block"><!--  pt-5 -->
                    <?php
                        $home_background = setting('home_background');
                        $home_background = $home_background ? url($home_background) : url('assets/images/couple.png');
                    ?>
                    <img class="set-image" src="{!! $home_background !!}">
                </div>
                <div class="col-md-6">
                    <div class="row" class="set-login">
                        <div class="col-md-9 mx-auto pt-5">
                          @if(Session::has('resetAlert'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Warning!</strong> {!! session()->get('resetAlert') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                                {{ session()->forget('resetAlert') }}
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
                                                <li>{!! $error !!}</li>
                                        @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                            @endif
                            <form method="post" class="login_forms" action="{{ url('/reset-passwrod') }}">
                                {!! csrf_field() !!}
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <div class="form-group">
                                  <input type="password" class="form-control" placeholder="Enter password" id="pwd" name="password" required>
                                </div>
                                <div class="form-group">
                                  <input id="confirm_password" type="password" class="form-control" name="confirm_password" placeholder="Confirm password" required>
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


