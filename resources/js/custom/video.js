$(function () {  
    var token = $('meta[name=csrf_token]').attr('content'); 
    var video = $('#video-element').data('video');
    var url = $('#video-element').data('url');
    var avater = $('#video-element').data('avater');
    var name = $('#video-element').data('name');
    var receiver_url = $('#video-element').data('receiver-url');
    var sender_url = $('#video-element').data('sender-url');
    var main_url = $('#video-element').data('main-url');
    var caller_url = $('#video-element').data('caller-url');
    var user_name = $('#video-element').data('username');
  
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
                  
            
                    Twilio.Video.connect((logged_id === video.sender_id) ? video.access_token : video.access_token_2 ,{ 
                            name: video.room_name,
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
                        if(logged_id == video.sender_id){
                            socket.emit('call-incoming', {sender_id: video.sender_id, url: url, avatar: avater, receive_id:video.receive_id, name: name});
                        }
                        room.on('participantDisconnected', participantDisconnected);
                        room.once('disconnected', error => room.participants.forEach(participantDisconnected));
                        $(document).on('click', 'a[data-ajax]', function(e) {
                            room.disconnect();
                        });
                        $(document).on('click', '.end_vdo_call', function(e) {
                                if(confirm('You are on call. Are you sure to exit?')){  
                                    if(logged_id == video.sender_id){
                                        socket.emit('cancel-call',{ receive_id: video.receive_id }); 
                                    }
                                    room.disconnect(); 
                                    if(logged_id == video.sender_id){
                                            window.location.href = receiver_url;
                                       } 
                                    if(logged_id == video.receive_id){
                                        window.location.href = sender_url;
                                    }
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
                        window.location.href = main_url;
                        $('.audiojs').empty();
                    }

                    function trackAdded(div, track) {
                        div.appendChild(track.attach());
                    }

                    function trackRemoved(track) {
                        track.detach().forEach(element => element.remove());
                    }
                    socket.on('reject-call', function (data) {  
                        var auth = logged_id;
                        if(data.sender_id == auth){
                            window.location.href = caller_url + data.receive_id;  
                        } 
                    })
                    
                },1000); 
            }
                
        function errorHandler(){ 
            if(confirm('Camera not found! Please go back.')) { 
                socket.emit('camera-not-found', {sender_id: video.sender_id, username: user_name}); 
                setTimeout(() => { 
                    if(logged_id == video.sender_id){
                        window.location.href = receiver_url;
                    } 
                    if(logged_id == video.receive_id){
                        window.location.href = sender_url;
                    }
                }, 500);
            }
        }
        $(document).on('click', '.end_vdo_call_before', function(e) { 
            if(confirm('You are on call. Are you sure to exit?')){ 
                if(logged_id == video.sender_id){
                    socket.emit('cancel-call',{ receive_id: video.receive_id }); 
                }
               
                if(logged_id == video.sender_id){
                    window.location.href = receiver_url;
                } 
                if(logged_id == video.receive_id){
                    window.location.href = sender_url;
                }
        }  
        });
        socket.on('camera-not-found', function (data) {  
            if(confirm(data.username+' camera is not found! Please go back.')) {  
                    if(logged_id == video.sender_id){
                        window.location.href = receiver_url;
                    }
                }
         })
   
});