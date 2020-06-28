@extends('layouts.default') 
@section('content')   
@section('page_description')
   Users follows and unfollows page 
@endsection  
<div class="main-content"> 
    <div class="page-title text-capitalize m-0">
       <div class="w-100">Dashboard</div> 
    </div>
    <div style="text-align: center;height: 200px;background: #f1f1f1; padding: 20px;" id="main__user_id" data-id="{{ auth()->user()->id }}">
        <h2 style="color: rgb(254, 55, 111)">Hi {!! fullname(auth()->user()->firstname, auth()->user()->lastname, auth()->user()->username) !!}!</h2>
        <h6 style="text-align: center;">Whats your Status today?</h6>
                        
        <div class="status__message_main">
            <div class="status__message">
                <div class="emojis" id="emojis">
                    <span><i class="fas fa-grin"></i></span>
                    <div class="list-emojis" id="list-emojis">
                        @foreach(emojis() as $item)
                            <a href="javascript:void(0)">{!! $item !!}</a>
                        @endforeach
                    </div>
                </div> 
                    <input type="text" class="status__input" name="status" id="status__input" placeholder="Share with the world!">  
                    <button type="button" class="status__btn"><i class="fa fa-arrow-right"></i></button> 
            </div>
        </div>
    </div>

    <div class="mt-3 col-lg-12">
        <div class="follow__main_tab">
            <div class="follow__tab">
                <div class="tab_heading" data-tab="trending"> 
                    <div class="tab__text">What's trending</div>
                </div>
                <div class="tab_heading" data-tab="followers"> 
                    <div class="follow__text">Followers</div>
                </div>
                <div class="tab_heading" data-tab="following"> 
                    <div class="follow__text">Following</div>
                </div>
                <div class="tab_heading"  data-tab="whotofollow"> 
                    <div class="tab__text">Who to follow</div>
                </div>
                <div class="tab_heading" data-tab="notifications"> 
                    <div class="tab__text">Notifications</div>
                </div>
            </div>
        </div>
        <div class="follow__main_content"> 
            <div class="row contents"></div> 
            <div class="loader"></div>
            <div class="not_found mt-4"></div>
           <div class="d-flex justify-content-center mt-4" id="load__more_main"></div>
        </div> 
    </div>
  </div> 
@endsection 
@section('javascript')  
<script src="{!! url('assets/js/follows.js') !!}"></script>
@endsection
