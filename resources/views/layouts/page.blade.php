<!DOCTYPE html>
<html>
<head>
  @include('partials.header')
  @include('partials.navbar')
    @yield('stylesheet')
</head>
<body>
<div class="pages">
    <div class="header-page m-0 p-3" style="overflow:hidden">
        <div class="main m-0 p-0" style="bottom: 0">
            <div class="ml-2">
                {!! isset($page_title)?$page_title: '&nbsp;' !!}
            </div>
        </div>
    </div>
    <div class="container-fluid main_container">
        @include('partials.sidebar')
        <div class="main">
            @yield('content')

        </div>
    </div>
</div>
<script>
    var ajax_url = '{!! route('ajax') !!}'; 
    var socket_url = 'https://datev2.com/'; 
    var logged_id = {!! auth()->check() ? auth()->id() : 'false' !!};
</script>
<script src="{!! url('assets/js/app.js') !!}"></script>
<script src="{!! url('assets/js/socket.js') !!}"></script>
 <!-- <script src="http://localhost/dating/assets/js/app.js"></script>
<script src="http://localhost/dating/assets/js/socket.js"></script> -->
@yield('javascript')
</body>
</html>
