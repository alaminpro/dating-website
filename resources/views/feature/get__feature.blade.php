@foreach($users as $user) 
<div class="col-lg-4 col-sm-6">
    <div class="feature__users_main" data-id="{{ $user->id }}">
        <div class="select__icon">
           <i class="far fa-check-circle"></i>
        </div>
        <img width="100" class="rounded-circle" src="{{  avatar($user->avatar,$user->gender)   }}" alt="username">
        <h2>{{ $user->username }}</h2>
    </div>
</div>   
@endforeach