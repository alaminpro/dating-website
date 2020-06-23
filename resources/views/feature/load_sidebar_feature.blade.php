@foreach($features as $feature)
    <li data-toggle="tooltip" data-placement="top" title="{{ $feature->feature_user->username }}">
        <img class="feature__user_image" src="{{  avatar($feature->feature_user->avatar,$feature->feature_user->gender)   }}" alt="Feature User">
    </li>  
@endforeach