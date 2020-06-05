@extends('layouts.default')

@section('page_title')
{{ "| Calling to ". $video->receive->username }}
@endsection

@section('content')
    <style>
        .audiojs{
            display: none;
        }
        .vcall > h2 {
            color:white !important;
            font-weight:300 !important;
            font-size:2.4rem;
        }
        .typin-x {
            color:#a3ffa3 !important
        }
        .typing-dot {
            background-color:orange !important;
        }
 </style>
    <div class="clearfix">
      <div class="main-contents">
      <div class="page-title text-capitalize m-0">
          <h2 class="m-0">Video Call Lobby</h2>
      </div>
      <div class="row m-0">
        <div class="col-md-12 p-0 m-0">
        <div class="video-con" > 
        <div id="remote-media">
            <div class="username_intecator vcall"> 
                @if(auth()->id() === $video->sender_id)
                <h2 class="text-center text-capitalize">Calling {{$video->receive->username}}</h2> 
                <div class="typing text-center typin-x">Connecting 
                    <span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>&nbsp;
                    please wait
                </div>
            @else
            <h2 class="text-center text-capitalize">Incoming {{$video->sender->username}}</h2> 
                <div class="typing text-center typin-x">Connecting 
                    <span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>&nbsp;
                    please wait
                </div>
            @endif
            </div>
           @if(auth()->id() === $video->sender_id)
             <div class="call-animation">
                <img class="rounded-circle" src="{!! avatar($video->receive->avatar, $video->receive->gender) !!}" alt="" width="135"/>
            </div>
           @else
           <div class="call-animation">
                <img class="rounded-circle" src="{!! avatar($video->sender->avatar, $video->sender->gender) !!}" alt="" width="135"/>
            </div>
           @endif 
           <audio class="d-none" id="audioFrenata" controls="controls"  autoplay loop style="display:none" > 
                <source class="d-none" src="{!! url('assets/waiting.mp3') !!}" type="audio/mpeg">
            </audio> 
        </div>
        <div id="controls">
            <div id="preview">
                <div id="local-media"><video id="basic-stream" class="videostream" autoplay=""></video></div>
            </div>
            <div id="invite-controls"></div>
            <div id="log"><p></p></div>
        </div>
        <button class="btn end_vdo_call d-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,9C10.4,9 8.85,9.25 7.4,9.72V12.82C7.4,13.22 7.17,13.56 6.84,13.72C5.86,14.21 4.97,14.84 4.17,15.57C4,15.75 3.75,15.86 3.5,15.86C3.2,15.86 2.95,15.74 2.77,15.56L0.29,13.08C0.11,12.9 0,12.65 0,12.38C0,12.1 0.11,11.85 0.29,11.67C3.34,8.77 7.46,7 12,7C16.54,7 20.66,8.77 23.71,11.67C23.89,11.85 24,12.1 24,12.38C24,12.65 23.89,12.9 23.71,13.08L21.23,15.56C21.05,15.74 20.8,15.86 20.5,15.86C20.25,15.86 20,15.75 19.82,15.57C19.03,14.84 18.14,14.21 17.16,13.72C16.83,13.56 16.6,13.22 16.6,12.82V9.72C15.15,9.25 13.6,9 12,9Z" /></svg> End call
        </button>
        <button class="btn end_vdo_call_before">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,9C10.4,9 8.85,9.25 7.4,9.72V12.82C7.4,13.22 7.17,13.56 6.84,13.72C5.86,14.21 4.97,14.84 4.17,15.57C4,15.75 3.75,15.86 3.5,15.86C3.2,15.86 2.95,15.74 2.77,15.56L0.29,13.08C0.11,12.9 0,12.65 0,12.38C0,12.1 0.11,11.85 0.29,11.67C3.34,8.77 7.46,7 12,7C16.54,7 20.66,8.77 23.71,11.67C23.89,11.85 24,12.1 24,12.38C24,12.65 23.89,12.9 23.71,13.08L21.23,15.56C21.05,15.74 20.8,15.86 20.5,15.86C20.25,15.86 20,15.75 19.82,15.57C19.03,14.84 18.14,14.21 17.16,13.72C16.83,13.56 16.6,13.22 16.6,12.82V9.72C15.15,9.25 13.6,9 12,9Z" /></svg> End call
        </button>
    </div>
        </div>
      </div>
    </div> 
</div>
@endsection
@section('javascript') 
    <script src="{!! url('assets/js/audio.min.js') !!}"></script>
    <script> 
            
        $(function () {  
            var token = $('meta[name=csrf_token]').attr('content'); 
            var socket = io(socket_url, {
                path: '/node/socket.io',
                transports: ['polling','websocket']
            });
            audiojs.events.ready(function() {
                var as = audiojs.createAll();
            });
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

                    function streamHandler(stream){   
                        setTimeout(function(){

                            $('#audioFrenata').on('ended', function() {
                                    manageImageObjectsLevel();
                            }).get(0).play();

                            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
                            if (!navigator.getUserMedia) {
                                $('#remote-media h3').text('Sorry, WebRTC is not available in your browser.');
                            }
                            navigator.mediaDevices.getUserMedia({ 
                                video: true
                            }).then(function(s){
                                var video = document.getElementById('basic-stream'); 
                                video.srcObject = s; 
                            });
                          

                            Twilio.Video.connect('{!! (auth()->id() === $video->sender_id)?$video->access_token:$video->access_token_2 !!}',{ 
                                    name: '{!! $video->room_name !!}',
                                    audio: true,  
                                    video: { height: 720, frameRate: 24, width: 1280 },
                                    bandwidthProfile: {
                                        video: {
                                        mode: 'grid',
                                        maxTracks: 10,
                                        renderDimensions: {
                                            high: {height:1080, width:1980},
                                            standard: {height:720, width:1280},
                                            low: {height:176, width:144}
                                        }
                                        }
                                    },
                                    maxAudioBitrate: 16000, //For music remove this line
                                    //For multiparty rooms (participants>=3) uncomment the line below
                                    //preferredVideoCodecs: [{ codec: 'VP8', simulcast: true }],
                                    networkQuality: {local:1, remote: 1}
                                  }).then(room => { 
                                room.participants.forEach(participantConnected);
                                room.on('participantConnected', participantConnected);
                                @if(auth()->id() == $video->sender_id)
                                    socket.emit('call-incoming', {sender_id: {!! $video->sender_id !!}, url: '{!! route('video',['id'=>$video->id]) !!}', avatar: '{!! avatar($video->sender->avatar, $video->sender->gender) !!}', receive_id: {!! $video->receive_id !!}, name: '{!! fullname($video->sender->firstname, $video->sender->lastname, $video->sender->username) !!}'});
                                @endif
                                room.on('participantDisconnected', participantDisconnected);
                                room.once('disconnected', error => room.participants.forEach(participantDisconnected));
                                $(document).on('click', 'a[data-ajax]', function(e) {
                                    room.disconnect();
                                });
                                $(document).on('click', '.end_vdo_call', function(e) {
                                        if(confirm('You are on call. Are you sure to exit?')){ 
                                            @if(auth()->id() ==  $video->sender_id)
                                                socket.emit('cancel-call',{ receive_id: {!! $video->receive_id !!}}); 
                                            @endif
                                            room.disconnect(); 
                                                @if(auth()->id() == $video->sender_id)
                                                    window.location.href = '{!! url('videos?caller_id='. $video->receive_id) !!}';
                                                @endif
                                                @if(auth()->id() == $video->receive_id)
                                                    window.location.href = '{!! url('videos?caller_id='. $video->sender_id) !!}';
                                                @endif
                                    }  
                                });
                            }); 
                                 
                            function participantConnected(participant) { 
                                const div = document.createElement('div');
                                div.id = participant.sid;
                                //div.innerText = participant.identity;

                                participant.on('trackAdded', track => trackAdded(div, track));
                                participant.tracks.forEach(track => trackAdded(div, track));
                                participant.on('trackRemoved', trackRemoved);

                                $('#remote-media').html(div); 
                                $('.end_vdo_call').removeClass('d-none');  
                                $('.end_vdo_call_before').addClass('d-none');
                                $('.audiojs').empty();
                            }
                           
                            function participantDisconnected(participant) { 
                                participant.tracks.forEach(trackRemoved);
                                document.getElementById(participant.sid).remove();
                                window.location.href = '{!! route('videos') !!}';
                                $('.audiojs').empty();
                            }

                            function trackAdded(div, track) {
                                div.appendChild(track.attach());
                            }

                            function trackRemoved(track) {
                                track.detach().forEach(element => element.remove());
                            }
                            socket.on('reject-call', function (data) {  
                                var auth = '{{auth()->id()}}';
                                if(data.sender_id == auth){
                                    window.location.href = '{!! url('videos?caller_id=') !!}'+data.receive_id;  
                                } 
                            })
                            
                        },1000); 
                    }
                        
                function errorHandler(){ 
                    if(confirm('Camera not found! Please go back.')) { 
                        socket.emit('camera-not-found', {sender_id: {!! $video->sender_id !!}, username:'{!! $video->receive->username !!}'}); 
                        setTimeout(() => {
                            @if(auth()->id() == $video->sender_id)
                                window.location.href = '{!! url('videos?caller_id='. $video->receive_id) !!}';
                            @endif
                            @if(auth()->id() == $video->receive_id)
                                window.location.href = '{!! url('videos?caller_id='. $video->sender_id) !!}';
                            @endif
                        }, 500);
                    }
                }
                $(document).on('click', '.end_vdo_call_before', function(e) { 
                    if(confirm('You are on call. Are you sure to exit?')){ 
                        @if(auth()->id() ==  $video->sender_id)
                            socket.emit('cancel-call',{ receive_id: {!! $video->receive_id !!}}); 
                        @endif 
                        @if(auth()->id() == $video->sender_id)
                            window.location.href = '{!! url('videos?caller_id='. $video->receive_id) !!}';
                        @endif
                        @if(auth()->id() == $video->receive_id)
                            window.location.href = '{!! url('videos?caller_id='. $video->sender_id) !!}';
                        @endif
                }  
                });
                socket.on('camera-not-found', function (data) {  
                    if(confirm(data.username+' camera is not found! Please go back.')) {  
                            @if(auth()->id() ==  $video->sender_id)
                                window.location.href = '{!! url('videos?caller_id='. $video->receive_id) !!}';
                            @endif 
                        }
                 })
           
        });
    </script>
@endsection
