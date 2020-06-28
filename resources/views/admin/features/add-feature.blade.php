@extends('admin.layout')
@section('title')
    <title> Add New Feature</title>
@endsection
@section('content')
   <div  class="d-flex justify-content-between">
    <h3>Add New Feature</h3>
   <a href="{{route('admin_feature',"tab=premium")}}" class="btn btn-primary">Back</a>
   </div>
<form action="{{route('admin_feature_store')}}" method="post">
        {!! csrf_field() !!}
        <div class="form-group">
            <label>Text</label>
            <textarea rows="3" class="form-control" id="text" name="text" >{{ old('text') }}</textarea>
            <span class="text-danger">{{ $errors->has('text')? $errors->first('text'): '' }}</span>
        </div> 
        <div class="form-group">
            <label>Coin text</label>
            <input type="text"  class="form-control" name="coin" id="coin" value="{{ old('coin') }}">
            <span class="text-danger">{{ $errors->has('coin')? $errors->first('coin'): '' }}</span>
        </div>
        <div class="form-group">
            <label>Coin</label>
            <input type="number" class="form-control" name="value" id="value" value="{{ old('value') }}" >
            <span class="text-danger">{{ $errors->has('value')? $errors->first('value'): '' }}</span>
        </div>
        <div class="form-group">
            <label for="days">Days</label>
            <select name="days" id="days" class="form-control">
                <option value="" selected>Select days</option>
                <option value="1"  {{ old('days') == 1 ? 'selected' : '' }}>1 Days</option>
                <option value="2" {{ old('days') == 2 ? 'selected' : '' }}>2 Days</option>
                <option value="3" {{ old('days') == 3 ? 'selected' : '' }}>3 Days</option>
                <option value="4" {{ old('days') == 4 ? 'selected' : '' }}>4 Days</option>
                <option value="5" {{ old('days') == 5 ? 'selected' : '' }}>5 Days</option>
                <option value="6" {{ old('days') == 6 ? 'selected' : '' }}>6 Days</option>
                <option value="7" {{ old('days') == 7 ? 'selected' : '' }}>1 Week</option>
                <option value="14" {{ old('days') == 14 ? 'selected' : '' }}>14 Days</option>
                <option value="15" {{ old('days') == 15 ? 'selected' : '' }}>15 Days</option>
                <option value="20" {{ old('days') == 20 ? 'selected' : '' }}>20 Days</option>
                <option value="30" {{ old('days') == 30 ? 'selected' : '' }}>1 Month</option>
            </select>
            <span class="text-danger">{{ $errors->has('days')? $errors->first('days'): '' }}</span>
        </div>
         
        <div class="form-group">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
         
    </form>
@endsection
 