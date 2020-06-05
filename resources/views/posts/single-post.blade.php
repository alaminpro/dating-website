@extends('layouts.default')
@section('stylesheet')
 
@endsection 
    @section('meta')
        <meta name="keywords" content="{{$post->keywords}}">
    @endsection  
    @section('page_description')
        {{ "$post->description" }}
    @endsection
    @section('page_title')
        {{ " |  $post->title" }}
    @endsection
    @section('social_image')
        {{asset("uploads/". $post->image)}}
    @endsection 

@section('content')
<div class="main-content">
    <div class="page-title text-capitalize">
        <h2 class="m-0">{{ ucfirst($post->title) }}</h2>
    </div>
    <div class="main-photos">
         <div class="row m-0"> 
                <div class="col-lg-8 mb-4">
                    <div class="card custom-card">
                        <div class="card-body p-0">
                        <a href="{{ route('singleBlogPost', $post->slug) }}">
                            <div class="image__box" style="background-image: url('{{asset("uploads/". $post->image)}}')"> </div>
                        </a>
                            <div class="post_title_body p-4"> 
                                <p class="page__details"> {!! $post->content !!}
                                </p>
                            </div>
                        </div>
                        <div class="comments-section">
                            <h3>Comments</h3>
                            <div class="text-center">
                                <h6>Add a new comment</h6>
                                <a href="#" class="btn btn-comment">Coming Soon</a>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-4">
                    <div class="card custom-card position-sticky" style="top: 60px" >
                        <div class="card-title">
                           <h3 class="related__articles">Related Articles</h3>
                        </div>
                        <div class="card-body pt-0 px-2">
                            @foreach($posts as $data)  
                                <ul class="list-group">
                                    <li class="list-group-item p-0 mb-2 d-flex align-items-center">
                                        <a href="{{ route('singleBlogPost', $data->slug) }}" class="d-flex">
                                            <img src="{{asset("uploads/". $data->image)}}" class="img-latest pr-2"/>
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
</div> 
@endsection
