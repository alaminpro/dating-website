const mix = require('laravel-mix');

 
/*
* mix for backend
*/
mix.js('resources/js/app.js', 'public/assets/js/')
   .sass('resources/sass/app.scss', 'public/assets/css/');
// for admin css and js complile
mix.js('resources/js/admin/admin.js', 'public/assets/js/'); 
mix.sass('resources/sass/admin/admin.scss', 'public/assets/css/');
// for custome js
mix.js('resources/js/custom/custom.js', 'public/assets/js/'); 
mix.js('resources/js/custom/follows.js', 'public/assets/js/');
mix.js('resources/js/custom/profile.js', 'public/assets/js/');
mix.js('resources/js/custom/setting.js', 'public/assets/js/');
mix.js('resources/js/custom/register.js', 'public/assets/js/');
mix.js('resources/js/custom/socket.js', 'public/assets/js/');

mix.styles([
    'resources/sass/vendor/cropper.min.css',
    'resources/sass/vendor/datepicker.min.css',
    'resources/sass/vendor/flaticon.css', 
    'resources/sass/vendor/jquery.fancybox.min.css',
    'resources/sass/vendor/jquery.mcustomscrollbar.css',
    'resources/sass/vendor/jquery.toast.min.css',
    'resources/sass/vendor/no-uislider.css',
], 'public/assets/css/vendor.css');
mix.styles([
   'resources/sass/vendor/fontawesome.min.css',
], 'public/assets/css/fontawesome.min.css');


mix.scripts([  
   'resources/js/vendor/socket.io.js', 
   'resources/js/vendor/jquery.mcustomscrollbar.min.js',  
   'resources/js/vendor/datepicker.min.js', 
   'resources/js/vendor/jquery.fancybox.min.js', 
   'resources/js/vendor/jquery.form.min.js', 
   'resources/js/vendor/no-uislider.js', 
   'resources/js/vendor/audio.min.js', 
   'resources/js/vendor/jquery.toast.min.js', 
], 'public/assets/js/vendor.js');
 



