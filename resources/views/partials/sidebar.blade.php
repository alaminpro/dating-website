<aside class="sidebar">
  
   
    @if(auth()->check())
        <?php
        $user = auth()->user();
        $unread = $user->unread()->count();
        ?>
       <div class="sidebar__main"> 
            <ul class="list-unstyled mt-4">
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
            @if(auth()->user()->photos()->count())
           
            <div class="sidebar__featured">
                <h1 class="title" >Get Featured here</h1>
                <div class="feature__area">
                    <ul class="feature__ul p-0 m-0"> 
                        <li class="feature__auth_li" >
                            <img   class="feature__user_image" src="http://127.0.0.1:8000/uploads/photos/31/3c0c8b07acb6be3da40b44be9bfacf5d1586785741.jpg" alt="Feature User">
                            <div class="add__feature_btn"><i class="fas fa-plus"></i></div>
                        </li>
                        <li data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                            <img class="feature__user_image" src="http://127.0.0.1:8000/uploads/photos/31/3c0c8b07acb6be3da40b44be9bfacf5d1586785741.jpg" alt="Feature User">
                        </li> 
                    </ul>
                </div>
            </div>
         
         @endif 
    @else
        <div class="text-center text-black p-3 sidebar__main">
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