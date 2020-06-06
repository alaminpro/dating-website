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
        <div class="video-con" id="video-element" data-video="{{ $video }}" data-url="{!! route('video',['id'=>$video->id]) !!}" data-avater="{!! avatar($video->sender->avatar, $video->sender->gender) !!}" data-name="{!! fullname($video->sender->firstname, $video->sender->lastname, $video->sender->username) !!}" data-receiver-url="{!! url('videos?caller_id='. $video->receive_id) !!}" data-sender-url="{!! url('videos?caller_id='. $video->sender_id) !!}" data-main-url="{!! route('videos') !!}" data-caller-url="{!! url('videos?caller_id=') !!}" data-username="{!! $video->receive->username !!}"> 
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
<script src="{!! url('assets/js/video.js') !!}"></script>
@endsection
