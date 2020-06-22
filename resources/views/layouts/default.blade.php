<!DOCTYPE html>
<html> 
<head> 
    @include('partials.meta')
    @include('partials.styles')
    @yield('meta')
    @yield('stylesheet')
</head>

<body>
 
    <div class="landing"> 
        @if((Route::current()->getName() != 'home') && (Route::current()->getName() != 'register') && (Route::current()->getName() != 'forget'))
        @include('partials.navbar')
        @endif
        <div class="container-fluid m-0 p-0">  
            @if((Route::current()->getName() != 'home') && (Route::current()->getName() != 'register') && (Route::current()->getName() != 'forget'))
                 @include('partials.sidebar')  
                @if(auth()->check() && (Route::current()->getName() == 'landing' || Route::current()->getName() == 'follow'))
                    <main class="main right_sidebar_show">
                    @else
                    <main class="main">
                @endif
            @else
            <main>
            @endif 
            @auth
               <div class="main-pages">
                   @endauth
                    <div class="main-content_loader"></div>
                    <div class="main__search_item"></div>
                    @yield('content') 
                    @include('partials.footer')
                    @auth
               </div>
                @if((Route::current()->getName() != 'home') && (Route::current()->getName() != 'register') && (Route::current()->getName() != 'forget'))
                    @include('partials.right-sidebar')   
                @endif
               @endauth
              
            </main>   
        </div> 
    </div>
    
    @include('partials.scripts')
</body>

</html>