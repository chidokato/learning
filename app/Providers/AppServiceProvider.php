<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('siteSetting', Setting::query()->firstOrCreate([]));

        View::composer('frontend.*', function ($view) {
            $view->with('headerMenus', Menu::query()
                ->whereNull('parent_id')
                ->active()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->with('activeChildrenTree')
                ->get()
            );
        });

        View::composer('frontend.home', function ($view) {
            $view->with('courses', Post::query()
                ->where('type', Post::TYPE_COURSE)
                ->where('is_active', true)
                ->with(['category', 'seller'])
                ->latest('published_at')
                ->latest('id')
                ->paginate(9)
            );
        });
    }
}

