@extends('admin.layout')
@section('title')
    <title>Pages</title>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('assets/plugins/dataTables.bootstrap.min.css') }}">
@endsection
@section('content')
    <h3 class="clearfix">Pages<a class="btn btn-info float-right" href="{!! route('adminaddpage') !!}"><i class="fas fa-plus"></i> Add New</a></h3>
    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped" id="datatable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pages as $page)
                    <tr>
                        <td>
                            @if($page->type == 'page')
                            <a href="{!! route('page',['slug'=>$page->slug]) !!}">{!! $page->title !!}</a>
                            @else
                            <a href="{!! route('singleBlogPost',['slug'=>$page->slug]) !!}">{!! $page->title !!}</a>
                            @endif
                        </td>
                        <td>{!! $page->type == 0 ? 'Page' : 'Post' !!}</td>
                        <td>{!! $page->created_at !!}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{!! route('editpage',['id'=>$page->id]) !!}"><i class="fas fa-edit"></i> Edit</a>
                            <a onclick="return confirm('Are you sure?')" class="btn btn-warning btn-sm" href="{!! route('admindeletepage',['id'=>$page->id]) !!}"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
        </table>
    </div>
@endsection
@section('javascript')
<script src="{{ asset('assets/plugins/datatables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/dataTables.bootstrap.min.js') }}"></script> 

<script type="text/javascript">
    $(document).ready(function() {
      $('#datatable').DataTable();
  } );
</script>
@endsection 