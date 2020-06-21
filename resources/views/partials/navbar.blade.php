<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom datev2__navbar" >
    <?php
    $logo = setting('logo_second');
    $logo = $logo ? url($logo) : url('assets/images/logo_white.png');
    ?>
    <div class="navbar-brand datev2__navbar_brand m-0">
        <a href="{{ route('follow') }}"><img  src="{{ $logo }}" height="70" alt="CoolBrand"></a>
        <div class="sidebar__hide_icon">
            <i class="fas fa-align-justify"></i>
        </div>
    </div>
    <div class="datev2__right_side">
        <div class="datev2__search_main"> 
            <div class="search__area">
                <i class="fas fa-search"></i>
                <input type="text" class="datev2__search_input" id="datev2__main_searc" placeholder="Search by interest's or Keywords"/> 
            </div>
            <div class="search__cencel_area">
                <i class="far fa-times-circle"></i>
            </div>
        </div>
        @auth
        <ul class="datev2__ul d-flex align-items-center">
            <li class="dropdown px-2 search__icon"> 
                   <i class="fa fa-search"></i> 
            </li>
            <li class="dropdown px-3">
                <div class="notification_main">
                    <a class="notification" href="javascript:void(0)" id="notification" >
                        <div class="badge badge-danger" id="update__badge"></div>
                        <i class="far fa-bell"></i>
                    </a>
                    <div class="dropdown-menu notification__dropdown_menu">
                        <div class="tip"></div>
                         <header class="datev2_notification_header">
                             <h3 class="title">Notifications</h3>
                             <div class="mark_as">
                                 <button class="all__markasread">Mark as read</button>
                             </div>
                         </header>
                         <main class="datev2__notifications"> 
                             <div class="notification__loader"></div>
                            <div class="notification__data">
                                <ul class="notification__ul_nav"> </ul>
                            </div> 
                         </main>
                         <footer class="notification__footer">
                            <a href="{{ route('notifications') }}">See all</a>
                         </footer>
                      </div>
                </div>
            </li>
            <li class="dropdown  px-3">
                <div class="datev2__avater">
                    <a class="profile__photo" href="#" id="user_dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(auth()->user()->isOnline())
                            <span class="online-class-auth"></span>
                        @endif
                        <img src="{!! avatar(auth()->user()->avatar, auth()->user()->gender) !!}" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu user__dropdown_menu" aria-labelledby="user_dropdown">
                        <div class="tip"></div>
                        <a class="dropdown-item"  href="{!! route('profile', auth()->user()->username) !!}"">Profile</a>
                        <a class="dropdown-item"  href="{!! route('setting') !!}"">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"  href="{!! route('logout') !!}">Logout</a> 
                      </div>
                </div>
            </li>
            <li class="dropdown  px-3 right__sidebar_toggle"> 
                    <i class="far fa-chart-bar"></i> 
            </li>
        </ul>
        @endauth
    </div>  
  </nav>