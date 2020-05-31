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
    .custom-card{
        box-shadow: 0px 9px 20px -10px #dbdbdb;
    }
    .custom-h1 >h1 {
        color:rgb(67, 67, 67);
        font-size:1.3rem;
        font-weight:700;
        padding-top:10px;
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
    .image__box::after {
        content: "";
        display: block;
        padding-bottom: 60%
    }
    h2.page__title {
        font-size: 20px;
    }
</style>
@endsection
@section('page_title')
{{ "Blog posts | " }}
@endsection
@foreach($posts as $data)
    @section('meta')
    <meta name="keywords" content="{{$data->keywords}}">
    @endsection  
    @section('page_description')
        {{ "$data->description" }}
    @endsection
    @section('social_image')
    {{asset("uploads/". $data->image)}}
@endsection
@endforeach

@section('content')
    <div class="landing">
    <div class="container-fluid main_container"> 
        @include('partials.sidebar')
        <div class="main">
            <div class="main-content">
            <div class="page-title text-capitalize custom-h1 mb-4"><h1>Blog posts</h1></div>
            <div class="main-photos">
                 <div class="row m-0">
                    @foreach($posts as $data)
                        <div class="col-md-6 col-lg-4  mb-4">
                            <div class="card custom-card">
                                <div class="card-body p-0">
                                <a href="{{ route('singleBlogPost', $data->slug) }}">
                                    <div class="image__box" style="background-image: url('{{asset("uploads/". $data->image)}}')"> </div>
                                </a>
                                    <div class="post_title_body p-4">
                                        <a href="{{ route('singleBlogPost', $data->slug) }}"> <h2 class="page__title">{{ ucfirst($data->title) }}</h2>   </a>
                                        <p class="page__details">
                                            @if(!empty($data->excerpt))
                                            {{ $data->excerpt }}
                                            @else
                                            \Illuminate\Support\Str::words($data->content, 50,'...')
                                            @endif 
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                 </div>
                 <div class="w-100 d-flex justify-content-center">
                    {{ $posts->links() }}
                 </div>
            </div>
            @include('partials.footer')
            </div>
        </div>

    </div>
    </div>
@endsection
