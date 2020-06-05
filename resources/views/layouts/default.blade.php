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
        <div class="container-fluid m-0 p-0">  
            @if((Route::current()->getName() != 'home') && (Route::current()->getName() != 'register') && (Route::current()->getName() != 'forget'))
                 @include('partials.sidebar')  
                 <main class="main">
            @else
            <main>
            @endif
            
                @yield('content') 
                @include('partials.footer')
            </main>  
        </div> 
    </div>
    
    @include('partials.scripts')
</body>

</html>