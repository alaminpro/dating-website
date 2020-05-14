@extends('layouts.custome')
@section('stylesheet')
<style>
    .custom-h1{
        border-bottom: 1px solid #e5e5e5;
        background: #fafafa;
        position: sticky;
        top: 0;
        z-index: 9999;
    }
    .h1, h1 {
    font-size: 1.7rem !important;
}
    .custom-card{
        box-shadow: 0px 9px 20px -10px #dbdbdb;
    }
    .custom-h1 >h1 {
        color:#272727;
        font-size:1.7rem;
        font-weight:700;
        padding-top:20px;
    }
    .main-photos {
        min-height: 550px;
        width: 100%;
        padding-left: 5px;
    }
   .image__box{
        position: relative;
        overflow: hidden; 
        -moz-background-size: 100% 100%;
        -o-background-size: 100% 100%;
        background-size: 100% 100%;;
        width: 100%;
    } 
    .img-fluid {
        width:77px;
        height:66px;
        object-fit:cover;

    }
    .latest-posts {
        font-size:14px;
        font-weight:400;
        padding:3px;
    }
    .image__box::after {
        content: "";
        display: block;
        padding-bottom: 60%
    }
    h2.page__title {
        font-size: 26px;
    }
</style>
@endsection 
    @section('meta')
        <meta name="keywords" content="{{$post->keywords}}">
    @endsection  
    @section('page_description')
        {{ "$post->description" }}
    @endsection
    @section('page_title')
        {{ "$post->title | " }}
    @endsection
    @section('social_image')
        {{asset("uploads/". $post->image)}}
    @endsection 

@section('content')
    <div class="landing">
    <div class="container-fluid main_container"> 
        @include('partials.sidebar')
        <div class="main">
            <div class="page-title text-capitalize custom-h1 mb-4"><h1 class="page__title mb-4">{{ ucfirst($post->title) }}</h1></div>
            <div class="main-photos">
                 <div class="row m-0"> 
                        <div class="col-lg-8 mb-4">
                            <div class="card custom-card">
                                <div class="card-body p-0">
                                <a href="{{ route('singelBlogPost', $post->slug) }}">
                                    <div class="image__box" style="background-image: url('{{asset("uploads/". $post->image)}}')"> </div>
                                </a>
                                    <div class="post_title_body p-4">
                                        
                                        <p class="page__details"> {!! $post->content !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-4">
                            <div class="card custom-card position-sticky" style="top: 85px" >
                                <div class="card-title">
                                   <h3 class="page-title">Recent Post's</h3>
                                </div>
                                <div class="card-body py-0">
                                    @foreach($posts as $data)  
                                        <ul class="list-group">
                                            <li class="list-group-item p-0 mb-2 d-flex align-items-center">
                                                <a href="{{ route('singelBlogPost', $data->slug) }}" class="d-flex">
                                                    <img src="{{asset("uploads/". $data->image)}}" class="img-fluid pr-2"/>
                                                    <h4 class="latest-posts">{{ ucfirst($data->title) }}</h4>
                                                </a>
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                        </div> 
                 </div> 
            </div>
            @include('partials.footer')
        </div>

    </div>
    </div>
@endsection
