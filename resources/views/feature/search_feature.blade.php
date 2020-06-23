@foreach($user->following as $user) 
@php
    $feature = \App\Feature::where('logged_id', auth()->user()->id)->where('finished_date', '>', \Carbon\Carbon::now()->format('Y-m-d H:i:s'))->where('user_id', $user->id)->first();
@endphp
<div class="col-lg-4 col-sm-6">
    <div  @isset($feature)data-datetime="{{ $feature->finished_date }}" @endisset class="feature__users_main  @isset($feature){{ $feature->user_id == $user->id ? 'select__feature_user': '' }} @endisset" data-id="{{ $user->id }}" >
        <div class="select__icon">
           <i class="far fa-check-circle"></i>
        </div>
        <img width="100" class="rounded-circle" src="{{  avatar($user->avatar,$user->gender)   }}" alt="username">
        <h2>{{ $user->username }}</h2>
    </div>
</div>   
@endforeach