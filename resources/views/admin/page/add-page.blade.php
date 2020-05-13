@extends('admin.layout')
@section('title')
    <title> Add New Page</title>
@endsection
@section('content')
   <div  class="d-flex justify-content-between">
    <h3> Add New Page</h3>
   <a href="{{route('adminpages')}}" class="btn btn-primary">Back</a>
   </div>
<form action="{{route('adminaddpage')}}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group">
            <label>Title</label>
            <input class="form-control" name="title" placeholder="write your page title">
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea rows="10" class="form-control" id="summernote" name="content"></textarea>
        </div>
        <div class="form-group d-none">
            <label>Excerpt</label>
            <input class="form-control" name="excerpt" id="excerpt" placeholder="Write your post short excerpt">
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control">
                <option value="" selected>Select type</option>
                <option value="1">Post</option>
                <option value="0">Page</option>
            </select>
        </div>
        <strong>SEO Optional</strong>
        <hr>
        <div class="form-group">
            <label>Keywords</label>
            <input class="form-control" name="keywords"  placeholder="keywords">
        </div>
        <div class="form-group">
            <label>Description</label>
            <input class="form-control" name="description" placeholder="write a short description">
        </div>
        <div class="form-group">
            <label>Picture</label>
            <input name="image" type="file" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">Save Page</button>
        </div>
    </form>
@endsection

@section('javascript')
<script>
 $(document).ready(function(){
    $('#type').change(function(){
        var val = $(this).val();
        if(val == 1){
        $('#excerpt').parent().removeClass('d-none')
        console.log('post')
        } else{
            $('#excerpt').parent().addClass('d-none') 
        }
    })
 })
</script>
    
@endsection