@extends('layouts.default')

 
@section('content')   
@section('page_description')
   Users follows and unfollows page 
@endsection 
@section('stylesheet')

<style> 
.LoaderBalls {
    width: 90px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.LoaderBalls__item {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #ff007c;
}
.LoaderBalls__item:nth-child(1) {
    animation: bouncing 0.4s alternate infinite
        cubic-bezier(0.6, 0.05, 0.15, 0.95);
}
.LoaderBalls__item:nth-child(2) {
    animation: bouncing 0.4s 0.1s alternate infinite
        cubic-bezier(0.6, 0.05, 0.15, 0.95) backwards;
}
.LoaderBalls__item:nth-child(3) {
    animation: bouncing 0.4s 0.2s alternate infinite
        cubic-bezier(0.6, 0.05, 0.15, 0.95) backwards;
}

@keyframes bouncing {
    0% {
        transform: translate3d(0, 10px, 0) scale(1.2, 0.85);
    }
    100% {
        transform: translate3d(0, -20px, 0) scale(0.9, 1.1);
    }
}
        
    </style>
    
@endsection
<div class="main-content"> 
    <div class="page-title text-capitalize">
       <div class="w-100">Dashboard</div> 
    </div>
    <div style="text-align: center;height: 200px;background: #e3e3e3;padding: 20px;">
                      <h2>Hi {!! fullname(auth()->user()->firstname, auth()->user()->lastname, auth()->user()->username) !!}!
                        </h2><h6 style="text-align: center;">Whats your Status today?</h6>
<input type="text" placeholder="Share with the world!" style="height: 45px;width: 230px;padding: 20px;border-radius: 25px;border: 1px #c1c0c0 solid;margin: 15px;"></div>
    <div class="mt-3 col-lg-12">
        <div class="follow__main_tab">
            <div class="follow__tab">
                <div class="follow__followers "> 
                    <div class="follow__text">Followers</div>
                </div>
                <div class="follow__following"> 
                    <div class="follow__text">Following</div>
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

  @include('partials.footer')
@endsection

@section('javascript') 
<script src="{!! url('assets/js/follows.js') !!}"></script>
@endsection
