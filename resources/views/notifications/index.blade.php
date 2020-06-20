@extends('layouts.default')  
@section('page_description')
   all notifications 
@endsection  

@section('content')   
<div class="main-content notification__main_content"> 
    <div class="page-title text-capitalize m-0">
       <div class="w-100">Your Notifications</div> 
    </div>
    <main class="datev2__notifications "> 
        <div class="notifications__page_loader"></div>
       <div class="notification__data">
           <ul class="notification__page_ul_nav"> </ul>
       </div> 
    </main>
</div> 
@endsection 
@section('javascript')   
@endsection
