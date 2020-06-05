<aside class="sidebar hidden-sm hidden-xs2">
    <?php
    $logo = setting('logo_second');
    $logo = $logo ? url($logo) : url('assets/images/logo_white.png');
    ?>
    <a href="/" class="navbar-brand d-block text-center ml-2" style="min-height: 70px; overflow: hidden;">
        <img src="{{ $logo }}" height="70" alt="CoolBrand">
    </a>
    @if(auth()->check())
        <?php
        $user = auth()->user();
        $unread = $user->unread()->count();
        ?>
        <div class="p-3">
            <div class="text-center user-block text-black mb-3">
                <a href="{!! route('profile',['username'=>$user->username]) !!}" class="profile__photo">
                    @if($user->isOnline())
                        <span class="online-class-auth"></span>
                    @endif
                    <img src="{!! avatar($user->avatar, $user->gender) !!}" class="w-25 rounded-circle mb-2">
                </a>
                <a href="{!! route('profile',['username'=>$user->username]) !!}">
                    <p style="font-size: 1.2rem;margin:5px;" class="font-weight-bold text-capitalize mb-0">{!!
                        fullname($user->firstname, $user->lastname, $user->username) !!}</p>
                </a>
                @if($user->address !=null && $user->country)
                    <p style="font-size: 14px; font-weight:400;margin:5px;"><i class="fas fa-map-marker-alt"></i>
                        {{ $user->address }}</p>
                    <a href="{!! route('profile',['username'=>$user->username]) !!}" class="btn btn-upgrade">View
                        Profile</a>
                @endif
            </div>
        </div>
        <ul class="list-unstyled">
            <li><a class="{!! Illuminate\Support\Facades\Route::is('blog')?'active':'' !!}"
                    href="{!! route('blogPost') !!}">Blogs <i class="fas fa-book"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('landing')?'active':'' !!}"
                    href="{!! route('landing') !!}">People Nearby <i class="fas fa-search"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('follow')?'active':'' !!}"
                    href="{!! route('follow') !!}">Dashboard <i class="fa fa-user-plus" aria-hidden="true"></i>
                </a></li>
            <li id="message-sidebar"><a
                    class="{!! Illuminate\Support\Facades\Route::is('messages') || Illuminate\Support\Facades\Route::is('message')?'active':'' !!}"
                    href="{!! route('messages') !!}">Messages <span class="badge badge-pink">{!! $unread > 0 ? $unread:
                        '' !!}</span><i class="fas fa-comments"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('videos') || Illuminate\Support\Facades\Route::is('video')?'active':'' !!}"
                    href="{{ route('videos') }}">Video Chat <i class="fas fa-video"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('setting')?'active':'' !!}"
                    href="{!! route('setting') !!}">Setting <i class="fas fa-cog"></i></a></li>
            <!-- <li><a class="{!! Illuminate\Support\Facades\Route::is('Custome')?'active':'' !!}" href="{!! route('custome') !!}">Custome Page <i class="fa fa-file"></i></a></li> -->
            <li><a href="{!! route('logout') !!}">Logout <i class="fas fa-sign-out-alt"></i></a></li>
        </ul>
    @else
        <div class="text-center text-black p-3">
            <p class="text-capitalize font-weight-bold">Create an account</p>
            <form action="{!! route('quick_reg') !!}" method="post" id="formQuick">
                {{ csrf_field() }}
                <div class="form-group">
                    <input class="form-control form-control-sm" name="username" required placeholder="Username"
                        id="register-username">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-sm" type="password" name="password" required
                        placeholder="Password" id="quick-pass">
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" name="gender" id="quick-gender">
                        <option value="">Gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                    <i class="fa fa-chevron-down"></i>
                </div>
                <div class="form-group">
                    <input class="form-control form-control-sm" name="email" required placeholder="Email" type="email"
                        id="register-email">
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" name="country" id="quick-country">
                        <option value="">Location</option>
                        @foreach(countries() as $key=>$country)
                            <option value="{!! $key !!}">{!! $country !!}</option>
                        @endforeach
                    </select>
                    <i class="fa fa-chevron-down"></i>
                </div>
                <div class="form-group">
                    <button class="btn btn-gray btn-block btn-md" type="submit">Sign Up</button>
                </div>
                <p>OR</p>
                <div class="d-flex justify-content-center">
                    <div class="social__login">
                        <a href="{!! route('loginfacebook') !!}" class="btn-facebook"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="{!! route('logintwitter') !!}" class="btn-twitter"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </form>
        </div>
    @endif
</aside>