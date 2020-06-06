@extends('layouts.default')
@section('page_title')
{{ "| Video call" }}
@endsection
@section('content') 
    <div class="conversations clearfix">
      <div class="main-contents">
      <div class="page-title text-capitalize m-0">
          <h2 class="m-0">Video Call</h2>
      </div>
      <div class="row m-0">
        <div class="float-left list-conversations">
          <div class="video__call_sidebar">
            <div class="search-conversation">
                <input type="text" placeholder="Search" id="search-user">
                <i class="fas fa-search"></i>
            </div>
            <div class="scroll-bar">
              <ul id="search-data" class="list-unstyled mb-0"></ul>
              <ul id="user-data" class="list-unstyled mb-0"></ul>
            </div>
            <div class="d-flex w-100 justify-content-center loading"> </div>
          </div>
        </div>
        <div class="message-box">
            <div class="video-call-body d-flex align-items-center justify-content-center" >
            
            </div>
        </div>
      </div>
    </div> 
</div>

@endsection
@section('javascript')
<script src="{!! url('assets/js/video-all.js') !!}"></script>
@endsection