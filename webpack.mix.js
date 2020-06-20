const mix = require('laravel-mix');
 
/*
* mix for backend
*/
mix.js('resources/js/app.js', 'public/assets/js/')
   .sass('resources/sass/app.scss', 'public/assets/css/');
   
// for custome js
mix.scripts(['resources/js/custom/custom.js'], 'public/assets/js/custom.js'); 
mix.scripts(['resources/js/custom/follows.js'], 'public/assets/js/follows.js');
mix.scripts(['resources/js/custom/profile.js'], 'public/assets/js/profile.js');
mix.scripts(['resources/js/custom/setting.js'], 'public/assets/js/setting.js');
mix.scripts(['resources/js/custom/register.js'], 'public/assets/js/register.js');
mix.scripts(['resources/js/custom/socket.js'], 'public/assets/js/socket.js');
mix.scripts(['resources/js/custom/video-all.js'], 'public/assets/js/video-all.js');
mix.scripts(['resources/js/custom/video.js'], 'public/assets/js/video.js');
mix.scripts(['resources/js/custom/landing.js'], 'public/assets/js/landing.js');
mix.scripts(['resources/js/custom/map_script.js'], 'public/assets/js/map_script.js');

 

if (mix.inProduction()) {
   mix.version();
}