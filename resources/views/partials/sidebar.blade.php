<style>.w-25 {
width:25% !important;
}
.badge-pink {
	color: #fff;
	background-color: #ff70b3;
	width: 28px;
	/* padding-right: 3px; */
}</style><div class="sidebar hidden-sm hidden-xs2">
    <?php
    $logo = setting('logo_second');
    $logo = $logo ? url($logo) : url('assets/images/logo_white.png');
    ?>
    <!-- <p class="text-center logo mb-4">
        <a href="{!! url('/') !!}"><img src="{!! $logo !!}" class="img-fluid"></a>
    </p> -->
        <a href="/" class="navbar-brand d-block text-center ml-2" style="min-height: 70px; overflow: hidden;" >
            <!-- <img src="https://demo.myclouddate.com/uploads/sites/n52fiuUta9o8rUR5seeb.png" height="28" alt="CoolBrand"> -->
            <img src="{{$logo}}" height="70" alt="CoolBrand" >
        </a>
    @if(auth()->check())
        <?php
        $user = auth()->user();
        $unread = $user->unread()->count();
        ?>
        <div class="p-3">
            <div class="text-center user-block text-black mb-3">
                <a href="{!! route('profile',['username'=>$user->username]) !!}"><img src="{!! avatar($user->avatar, $user->gender) !!}" class="w-25 rounded-circle mb-2"></a>
                <a href="{!! route('profile',['username'=>$user->username]) !!}"> <p style="font-size: 1.2rem;margin:5px;" class="font-weight-bold text-capitalize mb-0">{!! fullname($user->firstname, $user->lastname, $user->username) !!}</p></a>
                @if($user->address !=null && $user->country)
                <p style="font-size: 14px; font-weight:400;margin:5px;"><i class="fas fa-users"></i> Popularity - Very Low</p>
                <a class="btn btn-upgrade">Upgrade Now!</a>
                @endif
          </div>
        </div>
        <ul class="list-unstyled">
        <li><a class="{!! Illuminate\Support\Facades\Route::is('blog')?'active':'' !!}" href="{!! route('blogPost') !!}">Blogs <i class="fas fa-book"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('landing')?'active':'' !!}" href="{!! route('landing') !!}">People Nearby <i class="fas fa-search"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('follow')?'active':'' !!}" href="{!! route('follow') !!}">Follow <i class="fa fa-user-plus" aria-hidden="true"></i>
            </a></li>
            <li id="message-sidebar"><a class="{!! Illuminate\Support\Facades\Route::is('messages') || Illuminate\Support\Facades\Route::is('message')?'active':'' !!}" href="{!! route('messages') !!}">Messages  <span class="badge badge-pink">{!! $unread > 0 ? $unread: '' !!}</span><i class="fas fa-comments"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('videos') || Illuminate\Support\Facades\Route::is('video')?'active':'' !!}" href="{{route('videos')}}">Video Chat <i class="fas fa-video"></i></a></li>
            <li><a class="{!! Illuminate\Support\Facades\Route::is('setting')?'active':'' !!}" href="{!! route('setting') !!}">Setting <i class="fas fa-cog"></i></a></li>
            <!-- <li><a class="{!! Illuminate\Support\Facades\Route::is('Custome')?'active':'' !!}" href="{!! route('custome') !!}">Custome Page <i class="fa fa-file"></i></a></li> -->
            <li><a href="{!! route('logout') !!}">Logout <i class="fas fa-sign-out-alt"></i></a></li>
        </ul>
    @else
        <div class="text-center text-black p-3">
            <p class="text-capitalize font-weight-bold">Create an account</p>
            <form action="{!! route('quick_reg') !!}" method="post" id="formQuick">
              {{csrf_field()}}
                <div class="form-group">
                    <input class="form-control form-control-sm" name="username" required placeholder="Username" id="register-username">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-sm" type="password" name="password" required placeholder="Password" id="quick-pass">
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
                    <input class="form-control form-control-sm" name="email" required placeholder="Email" type="email" id="register-email">
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
                <a href="{!! route('loginfacebook') !!}" class="btn btn-block btn-facebook btn-sm"><i class="fab fa-facebook-f"></i> Login with Facebook</a>
                <a href="{!! route('logintwitter') !!}" class="btn btn-block btn-twitter btn-sm"><i class="fab fa-facebook-f"></i> Login with Twitter</a>
            </form>
        </div>
    @endif
</div>
