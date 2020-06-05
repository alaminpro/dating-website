@extends('layouts.default')
@section('page_title')
{{ "| Conversations " }}
@endsection
@section('content') 
  <div class="conversations clearfix">
      <div class="main-content__message"> 
        <div class="page-title text-capitalize m-0">
            <h2 class="m-0">Conversations</h2>
        </div>
        <div class="float-left list-conversations">
            <div class="search-conversation">
                <input type="text" placeholder="Search">
                <i class="fas fa-search"></i>
            </div>
            <ul class="list-unstyled mb-0">
                @if($conversations->count())
                    @foreach($conversations as $key=>$conv)
                        @include('messages.item')
                    @endforeach
                    @else <div class="text-center mt-5"><i class="fas fa-frown frown"></i><h6>Bummer!</h6>Looks like you have no messages yet!</div>
                @endif
            </ul>
        </div>
        <div class="float-left message-box hidden-xs message__main_body"> 
            <?php
            if(!isset($conversation)){
                $conversation = $conversations->first();
            }
            ?> 
            @if($conversation)

                @include('messages.conversation')
                @else <div class="text-center mt-50">Lets go find some people to <b>follow and chat</b> with<br><a href="/browse" class="btn btn-primary mt-2"><b>Search!</b></a></div>
            @endif

        </div>
      </div> 
  </div>
    <script>
        function functionHide() {
            if (navigator.userAgent.match(/Android/i)
                || navigator.userAgent.match(/webOS/i)
                || navigator.userAgent.match(/iPhone/i)

                || navigator.userAgent.match(/BlackBerry/i)
                || navigator.userAgent.match(/Windows Phone/i)
            )
            {
                // $('.list-conversations').hide();
                $('.list-conversations').hide("slide", { direction: "left" }, 1000);
                $('.message-box').show();
            }

        }
    </script>
@endsection
