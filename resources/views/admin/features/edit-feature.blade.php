@extends('admin.layout')
@section('title')
    <title> Edit Feature</title>
@endsection
@section('content')

   <div  class="d-flex justify-content-between">
    <h3>Add New Feature</h3>
   <a href="{{route('admin_feature',"tab=premium")}}" class="btn btn-primary">Back</a>
   </div>

<form action="{{route('admin_feature_update', $edit->id)}}" method="post">
        {!! csrf_field() !!}
        <div class="form-group">
            <label>Text</label>
            <textarea rows="3" class="form-control" id="text" name="text">{{ $edit->text }}</textarea>
            <span class="text-danger">{{ $errors->has('text')? $errors->first('text'): '' }}</span>
        </div> 
        <div class="form-group">
            <label>Coin text</label>
            <input class="form-control" name="coin" id="coin" value="{{ $edit->coin }}">
            <span class="text-danger">{{ $errors->has('coin')? $errors->first('coin'): '' }}</span>
        </div>
        <div class="form-group">
            <label>Coin</label>
            <input class="form-control" name="value" id="value" value="{{ $edit->value }}">
            <span class="text-danger">{{ $errors->has('value')? $errors->first('value'): '' }}</span>
        </div>
        <div class="form-group">
            <label for="days">Days</label>
            <select name="days" id="days" class="form-control">
                <option value="" selected>Select days</option>
                <option value="1" {{ $edit->days == 1 ? 'selected' : ''}}>1 Days</option>
                <option value="2" {{ $edit->days == 2 ? 'selected' : ''}} >2 Days</option>
                <option value="3" {{ $edit->days == 3 ? 'selected' : ''}}>3 Days</option>
                <option value="4" {{ $edit->days == 4 ? 'selected' : ''}}>4 Days</option>
                <option value="5" {{ $edit->days == 5 ? 'selected' : ''}}>5 Days</option>
                <option value="6" {{ $edit->days == 6 ? 'selected' : ''}}>6 Days</option>
                <option value="7" {{ $edit->days == 7 ? 'selected' : ''}}>1 Week</option>
                <option value="14" {{ $edit->days == 14 ? 'selected' : ''}}>14 Days</option>
                <option value="15" {{ $edit->days == 15 ? 'selected' : ''}}>15 Days</option>
                <option value="20" {{ $edit->days == 20 ? 'selected' : ''}}>20 Days</option>
                <option value="30" {{ $edit->days == 30 ? 'selected' : ''}}>1 Month</option>
            </select>
            <span class="text-danger">{{ $errors->has('days')? $errors->first('days'): '' }}</span>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
         
    </form>
@endsection