@extends('layouts.custome')
@section('stylesheet')
<style>
    .main-photos{
        min-height: 550px;
    }
    .image__box{
        position: relative;
    }
    .image_main{
        width: 100%;
    }
    .image__box::after {
        content: "";
        display: block;
        padding-bottom: 100%
    }
</style>
@endsection

@foreach($posts as $data)
    @section('meta')
    <meta name="keywords" content="{{$data->keywords}}">
    @endsection 
    @section('page_title')
        {{ "$data->title | " }}
    @endsection

    @section('page_description')
        {{ "$data->description" }}
    @endsection
@endforeach

@section('content')
    <div class="landing">
    <div class="container-fluid main_container"> 
        @include('partials.sidebar')
        <div class="main">
            <div class="page-title text-capitalize custom-h1"><h1>Blog posts</h1>
            </div>
            <div class="main-photos">
                 <div class="row">
                    @foreach($posts as $data)
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="image__box">
                                        <img alt="{{ $data->title }}" class="image_main" src="{{asset("uploads/". $data->image)}}" />
                                    </div>
                                    <div class="post_title_body">
                                        <h2 class="page__title">{{ $data->title }}</h2>
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
            </div>
            @include('partials.footer')
        </div>

    </div>
    </div>
@endsection
