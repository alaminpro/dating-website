<!DOCTYPE html>
<html>
<head>
    @include('partials.header')
    @yield('stylesheet') 
</head>
<body>
    @if((Route::current()->getName() != 'home') && (Route::current()->getName() != 'register'))
<div class="header text-center p-2">
    <?php
        $logo = setting('website_logo');
        $logo = $logo ? url($logo) : url('assets/images/logo.png');
    ?> 

        <a href="/"><img class="set-welcome-logo" src="{!! $logo !!}"></a>
 
    
    
   
</div>
       
@endif
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
