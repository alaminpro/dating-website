<style>.badge-pink {
	color: #fff;
	background-color: #ff70b3;
	width: 28px;
	/* padding-right: 3px; */
}</style><div class="sidebar hidden-xs">
    <?php
    $logo = setting('logo_second');
    $logo = $logo ? url($logo) : url('assets/images/logo_white.png');
    ?>
    <!-- <p class="text-center logo mb-4">
        <a href="{!! url('/') !!}"><img src="{!! $logo !!}" class="img-fluid"></a>
    </p> -->
    @if(auth()->check())
        <?php
        $user = auth()->user();
        $unread = $user->unread()->count();
        ?>
        <div class="p-3">
            <div class="text-center user-block text-black mb-3">
                <a href="{!! route('profile',['username'=>$user->username]) !!}"><img src="{!! avatar($user->avatar, $user->gender) !!}" class="w-25 rounded-circle mb-2"></a>
                <p style="font-size: 1.2rem;margin:5px;" class="font-weight-bold text-capitalize mb-0">{!! fullname($user->firstname, $user->lastname, $user->username) !!}</p>
                @if($user->address !=null && $user->country)
                <p style="font-size: 14px; font-weight:400;margin:5px;"><i class="fas fa-users"></i> Popularity - Very Low</p>
                <a class="btn btn-upgrade">Upgrade Now!</a>
                @endif
          </div>
        </div>
        <ul class="list-unstyled">
            <li><a class="{!! Illuminate\Support\Facades\Route::is('landing')?'active':'' !!}" href="{!! route('landing') !!}">Browse <i class="fas fa-search"></i></a></li>
            <li id="message-sidebar"><a class="{!! Illuminate\Support\Facades\Route::is('messages') || Illuminate\Support\Facades\Route::is('message')?'active':'' !!}" href="{!! route('messages') !!}">Messages  <span class="badge badge-pink">{!! $unread > 0 ? $unread: '' !!}</span><i class="fas fa-comments"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('video')?'active':'' !!}" href="">Video Chat <i class="fas fa-video"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('setting')?'active':'' !!}" href="{!! route('setting') !!}">Setting <i class="fas fa-cog"></i></a></li>
            <li><a href="{!! route('logout') !!}">Logout <i class="fas fa-sign-out-alt"></i></a></li>
        </ul>


    @endif
</div>
