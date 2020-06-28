@foreach($features as $feature)
    <li data-toggle="tooltip" data-placement="top" title="{{ $feature->feature_user->username }}">
        <div class="delete__feature_user" data-id="{{ $feature->id }}">
            <i class="fas fa-times"></i>
        </div>
        <a href="{{ route('profile',$feature->feature_user->username) }}" class="p-0">
            <img class="feature__user_image" src="{{  avatar($feature->feature_user->avatar,$feature->feature_user->gender)   }}" alt="Feature User">
        </a>
    </li>  
@endforeach