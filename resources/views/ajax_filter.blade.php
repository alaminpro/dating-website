@if(count($users))
    <div class="row mb-3 ml-1 mr-1">
        @foreach($users as $user)
        @auth
        <div class="col-xs-12 col-lg-6  col-xl-4 ipad-col"> 
            @endauth
            @guest
            <div class="col-xs-12 col-lg-6  col-xl-3 ipad-col"> 
            @endguest
            <a href="{!! route('profile',['username'=>strtolower($user->username)]) !!}">
                <div class="user-item shadow-sm rounded effect" style="background-image: url('{!! avatar($user->avatar, $user->gender) !!}') ">
                    <div class="photo__main_content">
                        <div class="photos_status">
                            <span class="photos">
                                <i class="fas fa-camera"></i>
                               {!! $user->photos()->count() !!}</span>
                                @if($user->isOnline())
                                    <span class="online">
                                        <div class="badge__video_online">Live</div>
                                    </span> 
                                @endif
                        </div>
                        <div class="users__address">
                            <p class="fullname m-0">{!! fullname($user->firstname, $user->lastname, $user->username) !!}</p>
                            <p class="address m-0">{!! fulladdress($user->address, $user->country) !!}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
    </div>
@else
@endif
{!! $users->links() !!}
