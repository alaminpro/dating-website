<?php

namespace App\Providers;

use App\Feature;
use App\Page;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
            $pages = Page::where('type', 0)->orderBy('title')->get();
            $ads = Setting::where('meta', 'analytics_code')->first();
            $view->with('pages', $pages);
            $view->with('ads', $ads);
        });
        View::composer(['partials.sidebar'], function ($view) {
            $feature_users = Feature::with(['feature_user' => function ($q) {
                $q->select('id', 'username', 'birthday', 'avatar', 'gender');
            }])
                ->where('logged_id', auth()->user()->id)
                ->where('finished_date', '>', Carbon::now()->format('Y-m-d H:i:s'))->get();
            $view->with('feature_users', $feature_users);
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
