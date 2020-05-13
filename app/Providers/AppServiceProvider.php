<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Page;
use App\Setting;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        View::composer(['partials.footer'], function ($view) {
            $pages = Page::where('type',0)->orderBy('title')->get();
            $ads = Setting::where('meta','analytics_code')->first();
            $view->with('pages', $pages);
            $view->with('ads', $ads);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}