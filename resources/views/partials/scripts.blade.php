<script src="{!! url('assets/js/app.js') !!}"></script>
<script src="{!! url('assets/js/popper.min.js.map') !!}"></script>
@auth
    <script>
        var ajax_url = '{!! route('ajax') !!}';
        var ajax_url_follow = '{!! route('ajax_follow') !!}';
        var socket_url = 'https://datev2.com/'; 
        var logged_id = {!! auth()->check() ? auth()->id() : 'false' !!};
    </script> 
    <script src="{!! url('/assets/js/vendor.js') !!}"></script> 
    <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script> 
@endauth
    <audio src="{!! url('assets/message.mp3') !!}" id="message_audio"></audio> 
    <input type="hidden" value="{!! url('assets/tone.mp3') !!}" id="audio_source"/>
    <div class="notifications"></div> 

 
@auth
    <script src="{!! url('assets/js/custom.js') !!}"></script>
    <script src="{!! url('assets/js/socket.js') !!}"></script>
    <script src="{!! url('assets/js/socket.io.js.map') !!}"></script>
    <script>
        $(document).ready(function () {
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

            function streamHandler() {
                setTimeout(function () {
                    ajax_call();
                }, 1000);
            } 
            function errorHandler() {} 
            function ajax_call() {
                let data = {
                    id: '{!! auth()->user()->id !!}',
                    video: 1
                }
                $.ajax({
                    url: ajax_url,
                    data: {
                        action: 'update_user_video',
                        data,
                        _token: token
                    },
                    dataType: 'JSON',
                    type: 'POST',
                })
            }
        })
    </script>
@endauth

@yield('javascript')