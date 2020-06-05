@extends('layouts.default')
 
@section('page_title')
{{ "| Blog posts" }}
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
    <div class="main-content">
        <div class="page-title text-capitalize">
            <h2 class="m-0">Blog posts</h2>
        </div>
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
                                    <a href="{{ route('singleBlogPost', $data->slug) }}"> 
                                        <h2 class="page__title">{{ ucfirst($data->title) }}</h2>   </a>
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
    </div> 
@endsection
