<!DOCTYPE html>
<html>
<head>
  @include('partials.header')
  @include('partials.navbar')
    @yield('stylesheet')
</head>
<body>
<div class="landing">
    <div class="container-fluid main_container">
        @include('partials.sidebar')
        <div class="main">
            @yield('content')


        </div>
    </div>
</div>
<script>
    var ajax_url = '{!! route('ajax') !!}';
    var ajax_url_follow = '{!! route('ajax_follow') !!}';
    var socket_url = 'https://155.138.219.81:2087';
    var logged_id = {!! auth()->check() ? auth()->id() : 'false' !!};
</script>
<script src="{!! url('assets/js/app.js') !!}"></script>
<script src="{!! url('assets/js/socket.js') !!}"></script>
@if(auth()->user()) 
<script>

 $(document).ready(function() {
    var token = $('meta[name=csrf_token]').attr('content');
        navigator.getUserMedia = (
        navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia
    );

    if (typeof navigator.mediaDevices.getUserMedia === 'undefined') {
        navigator.getUserMedia({
            audio: true,
            video: true
        }, streamHandler, errorHandler);
    } else {
        navigator.mediaDevices.getUserMedia({
            audio: true,
            video: true
        }).then(streamHandler).catch(errorHandler);
    }

    function streamHandler(){   
        setTimeout(function(){
            ajax_call();
        },1000); 
    }
    
    function errorHandler(){ 
    
    }
    function ajax_call(){ 
        let data = {
            id:  '{!! auth()->user()->id !!}',
            video: 1
        }
        $.ajax({
            url: ajax_url,
            data: {action: 'update_user_video', data, _token: token},
            dataType: 'JSON',
            type: 'POST',
        })
    }
 })
 
</script>
@endif
 <!-- <script src="http://localhost/dating/assets/js/app.js"></script>
<script src="http://localhost/dating/assets/js/socket.js"></script> -->
@yield('javascript')
</body>
</html>
