<?php

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
|
|
|
 */
Route::get('/', 'HomeController@main')->name('home')->middleware('logged');
Route::post('/', 'HomeController@postHome');
Route::get('/u/{username}', 'UserController@profile')->name('profile')->where('username', '[a-z0-9-_]+');
// Route::get('/photos/{username}','PhotoController@photos')->name('userphoto')->where('username','[a-z0-9-_]+');
Route::post('follow', 'FollowController@main')->name('ajax_follow');
Route::post('notification', 'NotificationsController@main')->name('ajax_notification');
Route::get('/page/{slug}', 'WelcomeController@dynamicPage')->name('page')->where('slug', '[a-z-]+');
Route::get('/blog', 'WelcomeController@BlogPost')->name('blogPost');
Route::get('/blog/{slug}', 'WelcomeController@SingleBlogPost')->name('singleBlogPost')->where('slug', '[a-z-]+');
Route::get('login/facebook', 'UserController@facebook')->name('loginfacebook')->middleware('logged');
Route::post('login', 'HomeController@postHome')->name('login');
Route::get('login/facebook/callback', 'UserController@facebookcallback')->name('loginfacebookcallback')->middleware('logged');
Route::get('login/twitter', 'UserController@twitter')->name('logintwitter')->middleware('logged');
Route::get('login/twitter/callback', 'UserController@twittercallback')->name('logintwittercallback')->middleware('logged');
Route::get('register', 'UserController@register')->name('register')->middleware('logged');
Route::post('register', 'UserController@postRegister')->name('register')->middleware('logged');
Route::get('logout', 'UserController@logout')->name('logout');
Route::get('browse', 'HomeController@landing')->name('landing')->middleware('complete');
Route::post('register/quick', 'UserController@quickRegister')->name('quick_reg');
Route::get('/forget-password', 'HomeController@forgetPassword')->name('forget');
Route::match(['get', 'post'], '/checkEmail', 'HomeController@checkEmail');
Route::get('/check-token/{token}', 'HomeController@checkToken');
Route::match(['get', 'post'], '/reset-passwrod', 'HomeController@ResetPassword');
Route::get('user/setting', 'UserController@setting')->name('setting')->middleware('auth');
Route::post('user/setting', 'UserController@postSetting')->middleware('auth');
/*
|--------------------------------------------------------------------------
| Protected Route for user
|--------------------------------------------------------------------------
|
|
|
 */
Route::middleware(['auth', 'complete'])->prefix('/')->group(function () {
    Route::post('upload/photo', 'PhotoController@upload')->name('upload_photo');
    Route::post('upload/crop-photo', 'PhotoController@crop_upload_photo')->name('crop_upload_photo');
    Route::get('messages', 'MessageController@messages')->name('messages');
    Route::post('message/upload', 'MessageController@upload')->name('message_upload');
    Route::get('message/{id}', 'MessageController@message')->name('message');
    Route::get('delete_message/{id}', 'MessageController@delete_message')->name('delete_message');
    Route::get('chat/{id}', 'MessageController@startChat')->name('chat');
    Route::get('videos', 'VideoController@videos')->name('videos');
    Route::get('video/{id}', 'VideoController@video')->name('video');
    Route::get('dashboard', 'FollowController@index')->name('follow');
    Route::post('dashboard/status', 'FollowController@updateStatus')->name('user_status');
    Route::get('notifications', 'NotificationsController@index')->name('notifications');
});

/**
 *
 * Custom page route
 */
Route::get('/custome', 'UserController@custome')->name('custome');
/**
 * Ajax
 *
 * */
Route::post('ajax', 'AjaxController@main')->name('ajax');

/**
 *
 * Admin Route
 *
 */

Route::get('admin/login', 'Admin\AuthController@login')->name('adminlogin');
Route::post('admin/login', 'Admin\AuthController@postLogin');

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('logout', 'Admin\AuthController@logout')->name('adminlogout');
    Route::post('ajax', 'Admin\AjaxController@main')->name('adminajax');
    Route::get('/', 'Admin\HomeController@main')->name('adminhome');
    Route::get('setting', 'Admin\SettingController@main')->name('adminsetting');
    Route::post('setting', 'Admin\SettingController@saveSetting')->name('adminsetting');
    Route::get('interests', 'Admin\SettingController@interests')->name('admininterest');
    Route::get('interests', 'Admin\CommonController@interests')->name('admininterest');
    Route::get('get_users', 'Admin\HomeController@get_users');
    Route::get('get_users_weekly', 'Admin\HomeController@get_users_weekly');
    Route::get('get_users_monthly', 'Admin\HomeController@get_users_monthly');
    /*Users*/
    Route::get('users', 'Admin\UserController@main')->name('adminusers');
    Route::get('user/{id}', 'Admin\UserController@edit')->name('adminedituser');
    Route::post('user/{id}', 'Admin\UserController@updateUser')->name('adminedituser');
    Route::get('user/delete/{id}', 'Admin\UserController@deleteUser')->name('admindeleteuser');
    /*Page*/
    Route::get('pages', 'Admin\HomeController@pages')->name('adminpages');
    Route::get('page/add/', 'Admin\HomeController@addPage')->name('adminaddpage');
    Route::post('page/add', 'Admin\HomeController@submitPage')->name('adminaddpage');
    Route::get('page/edit/{id}', 'Admin\HomeController@editPage')->name('editpage');
    Route::post('page/update/{id?}', 'Admin\HomeController@updatePage')->name('updatepage');
    Route::get('page/delete/{id}', 'Admin\HomeController@deletePage')->name('admindeletepage');
    /*features*/
    Route::get('features', 'Admin\FeatureController@index')->name('admin_feature');
    Route::get('feature/add/', 'Admin\FeatureController@create')->name('admin_feature_create');
    Route::post('feature/add', 'Admin\FeatureController@store')->name('admin_feature_store');
    Route::get('feature/edit/{id}', 'Admin\FeatureController@edit')->name('admin_feature_edit');
    Route::post('feature/update/{id}', 'Admin\FeatureController@update')->name('admin_feature_update');
    Route::get('feature/delete/{id}', 'Admin\FeatureController@delete')->name('admin_feature_delete');
    Route::post('feature/free/', 'Admin\FeatureController@admin_feature_free_store')->name('admin_feature_free');
});
// Route::get('/clear-cache', function() {
//     $exitCode = Artisan::call('cache:clear');
//     return redirect('/admin');
//     // return what you want
// });
