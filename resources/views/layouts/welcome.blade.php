<!DOCTYPE html>
<html>
<head>
    @include('partials.header')
    @yield('stylesheet') 
</head>
<body>
<div class="header text-center p-2">
    <?php
        $logo = setting('website_logo');
        $logo = $logo ? url($logo) : url('assets/images/logo.png');
    ?>
    @if(Route::current()->getName() == 'register')
        <div class="d-flex justify-content-between align-items-center">
            <a href="/" class="ml-0 ml-md-3"><img class="set-welcome-logo" src="{!! $logo !!}"></a>
            <div class="d-flex align-items-center">
                <p style="color: #333;" class="m-0 mr-3">Already a member?</p>
                <p class="text-center m-0">
                    <a class="btn btn-primary mr-0 mr-md-3 custom_btn" href="{!! route('home') !!}">Login</a>
                </p>
            </div>
        </div>
    @endif
    
    @if(Route::current()->getName() == 'home')
        <div class="d-flex justify-content-between align-items-center">
            <a href="/" class="ml-0 ml-md-3"><img class="set-welcome-logo" src="{!! $logo !!}"></a>
            <div class="d-flex align-items-center">
                <p style="color: #333;" class="m-0 mr-3">Create a new account?</p>
                <p class="text-center m-0">
                    <a class="btn btn-primary mr-0 mr-md-3 custom_btn" href="{!! route('register') !!}">Register now</a>
                </p>
            </div>
        </div>
    @endif
    @if((Route::current()->getName() != 'home') && (Route::current()->getName() != 'register'))
    <a href="/"><img class="set-welcome-logo" src="{!! $logo !!}"></a>
    @endif
</div>
@yield('content')
@yield('intro')
@include('partials.footer')
<script>
    var ajax_url = '{!! route('ajax') !!}';
</script>
<script src="{!! url('assets/js/app.js') !!}"></script>
@if(auth()->user()) 
<script src="{!! url('assets/js/socket.js') !!}"></script>
@endif
<!-- <script src="http://localhost/dating/assets/js/app.js"></script>
<script src="http://localhost/dating/assets/js/socket.js"></script> -->
@yield('javascript')

</body>
</html>
