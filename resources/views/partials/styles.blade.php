<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/app.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/fontawesome.min.css') !!}">

<link rel="stylesheet" type="text/css" href="{!! url('assets/css/vendor/jquery.mcustomscrollbar.css') !!}">
@if((Route::current()->getName() != 'home'))
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/vendor/cropper.min.css') !!}"> 
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/vendor/jquery.toast.min.css') !!}"> 
@endif
@auth
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/vendor/datepicker.min.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/vendor/jquery.fancybox.min.css') !!}">

@endauth
