<script src="{!! url('assets/js/app.js') !!}"></script> 
<script>
    var ajax_url = '{!! route('ajax') !!}';
    var ajax_url_follow = '{!! route('ajax_follow') !!}';
    var ajax_url_notification = '{!! route('ajax_notification') !!}';
    var socket_url = 'https://datev2.com/'; 
    var logged_id = {!! auth()->check() ? auth()->id() : 'false' !!};
</script> 
<audio src="{!! url('assets/message.mp3') !!}" id="message_audio"></audio> 
<input type="hidden" value="{!! url('assets/tone.mp3') !!}" id="audio_source"/>
<div class="notifications"></div>  
@auth
    <script src="{!! url('/assets/js/vendor/socket.io.js') !!}"></script>
    <script src="{!! url('assets/js/vendor/jquery.fancybox.min.js') !!}"></script>
    <script src="{!! url('assets/js/vendor/datepicker.min.js') !!}"></script>
    <script src="{!! url('assets/js/vendor/jquery.form.min.js') !!}"></script>
    <script src="{!! url('assets/js/vendor/jquery.mcustomscrollbar.min.js') !!}"></script> 
    <script src="{!! url('assets/js/vendor/audio.min.js') !!}"></script> 
    <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script> 
    <script src="{!! url('assets/js/socket.js') !!}"></script>  
@endauth
@if((Route::current()->getName() != 'home'))
<script src="{!! url('assets/js/vendor/jquery.toast.min.js') !!}"></script>
<script src="{!! url('assets/js/vendor/cropper.min.js') !!}"></script>
@endif
<script src="{!! url('assets/js/custom.js') !!}"></script>
<script src="{!! url('assets/js/map_script.js') !!}"></script> 
@yield('javascript')