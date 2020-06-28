@extends('admin.layout')
@section('title')
    <title>features</title>
@endsection
 
@section('content')

<div class="tab__main" data-tab-default="{{ setting('feature_upgrade') }}">
    <div class="tab__header">
        <ul class="tab__items">
            <li id="premimum__feature" class="tab__item" data-tab="premium">Premium Feature</li>
            <li id="free___feature" class="tab__item " data-tab="free">Free Feature</li> 
        </ul>
    </div>
    <div class="tab__content_main">
        <div class="tab__content" id="premium">
            <h3 class="clearfix">Premimum Features
                <a class="btn btn-info float-right" href="{{  route('admin_feature_create')  }}"><i class="fas fa-plus"></i> Add New</a></h3>
            <div class="table-responsive mt-3">
                @if(session('message'))
                <div id="message" class="alert alert-success">{{ session('message') }}</div>
               @endif 
                <table class="table table-bordered table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>Text</th>
                            <th>Coin</th>
                            <th>Value</th>
                            <th>Days</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($features as $feature)
                            <tr>
                                <td>{{ $feature->text }}</td>
                                <td>{{ $feature->coin }}</td>
                                <td>{{ $feature->value }}</td>
                                <td>{{ $feature->days }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{!! route('admin_feature_edit',['id'=>$feature->id]) !!}"><i class="fas fa-edit"></i></a>
                                    <a onclick="return confirm('Are you sure?')" class="btn btn-warning btn-sm" href="{!! route('admin_feature_delete',['id'=>$feature->id]) !!}"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                </table>
            </div>
        </div>
        <div class="tab__content" id="free">
            <h3 class="clearfix">Free Features</h3>
            @if(session('message'))
            <div id="message" class="alert alert-success">{{ session('message') }}</div>
           @endif 
            <form action="{{route('admin_feature_free')}}" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label>Text</label>
                    @php 
                      $edit =   App\AdminFeature::where('is_premimum', 0)->first();
                    @endphp
                    <input type="hidden" name="id" value="@isset($edit){{ $edit->id }}@endisset">
                    <textarea rows="3" class="form-control" id="text" name="text" >@isset($edit){{ $edit->text }}@endisset</textarea>
                    <span class="text-danger">{{ $errors->has('text')? $errors->first('text'): '' }}</span>
                </div>  
                <div class="form-group">
                    <label for="days">Days</label>
                    <select name="days" id="days" class="form-control">
                        <option value="" selected>Select days</option>
                        <option value="1" @isset($edit) {{ $edit->days == 1 ? 'selected' : ''}} @endisset>1 Days</option>
                        <option value="2" @isset($edit) {{ $edit->days == 2 ? 'selected' : ''}} @endisset >2 Days</option>
                        <option value="3" @isset($edit) {{ $edit->days == 3 ? 'selected' : ''}} @endisset>3 Days</option>
                        <option value="4" @isset($edit) {{ $edit->days == 4 ? 'selected' : ''}} @endisset>4 Days</option>
                        <option value="5" @isset($edit) {{ $edit->days == 5 ? 'selected' : ''}} @endisset>5 Days</option>
                        <option value="6" @isset($edit) {{ $edit->days == 6 ? 'selected' : ''}} @endisset>6 Days</option>
                        <option value="7" @isset($edit) {{ $edit->days == 7 ? 'selected' : ''}} @endisset>1 Week</option>
                        <option value="14" @isset($edit) {{ $edit->days == 14 ? 'selected' : ''}} @endisset>14 Days</option>
                        <option value="15" @isset($edit) {{ $edit->days == 15 ? 'selected' : ''}} @endisset>15 Days</option>
                        <option value="20" @isset($edit) {{ $edit->days == 20 ? 'selected' : ''}} @endisset>20 Days</option>
                        <option value="30" @isset($edit) {{ $edit->days == 30 ? 'selected' : ''}} @endisset>1 Month</option>
                    </select>
                    <span class="text-danger">{{ $errors->has('days')? $errors->first('days'): '' }}</span>
                </div>
                 
                <div class="form-group"> 
                        @if( isset($edit) &&  $edit->id  ) 
                        <button type="submit" class="btn btn-success">Update</button>
                        @else
                        <button type="submit" class="btn btn-success">Submit</button>
                        @endif
                   
                </div> 
            </form>
        </div>
    </div>
</div>




 
@endsection
 