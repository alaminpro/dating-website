@extends('layouts.default')
@section('stylesheet')
    <style>
.custom-h1 >h1 {
    color:rgb(101, 119, 134);
    font-size:1.3rem;
    font-weight:700;
padding-top:10px;
}
        .custom-description > h2 {
            font-size:1.3rem;
            font-weight:700;
            color: rgb(83, 84, 84);
            padding-top: 17px;
            margin-bottom: 15px;
}
.custom-content >h3, b {
    color:rgb(83, 84, 84);
    font-size:1.3rem;
}
 .custom-content {

            background:#ffffff;
}

        .custom-image
        {
            width:100%;
            height: 300px;
            object-fit:cover;
        }
        .custom-content-main
        {
            font-size: 25px;
        }
    </style>
    @endsection
@section('meta')
<meta name="keywords" content="{{$data->keywords}}">
@endsection

@section('page_title')
    {{ "$data->title | " }}
@endsection

@section('page_description')
    {{ "$data->description" }}
@endsection
@section('social_image')
    {{asset("uploads/". $data->image)}}
@endsection
@section('content') 
        <div class="main-contents">
            <div class="page-title text-capitalize m-0">
                <h2 class="m-0">{{ $data->title }}</h2>
            </div>
            <div class="main-photos">
                <div class="w-100"><img class="custom-image" alt="{{ $data->title }}" src="{{asset("uploads/". $data->image)}}"/></div>
                <div class="container-fluid custom-content">
                    <div class="custom-description"><h2>{{ $data->description }}</h2></div>
                    <p class="pl-3 custom-content-main">{!! $data->content !!}</p>
                </div>
            </div> 
        </div> 
@endsection
