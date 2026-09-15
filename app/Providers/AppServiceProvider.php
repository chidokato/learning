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
            $categoriesWithCourses = \App\Models\Category::query()
                ->where('is_active', true)
                ->whereHas('posts', function($query) {
                    $query->where('type', \App\Models\Post::TYPE_COURSE)->where('is_active', true);
                })
                ->orderBy('sort_order')
                ->get();

            // Laravel 9 applies eager-load limits across all parents, not per category.
            foreach ($categoriesWithCourses as $category) {
                $category->setRelation('posts', $category->posts()
                    ->where('type', Post::TYPE_COURSE)
                    ->where('is_active', true)
                    ->with(['category', 'seller'])
                    ->latest('published_at')
                    ->latest('id')
                    ->take(3)
                    ->get());
            }

            $view->with('courses', Post::query()
                ->where('type', Post::TYPE_COURSE)
                ->where('is_active', true)
                ->with(['category', 'seller'])
                ->latest('published_at')
                ->latest('id')
                ->paginate(9)
            )->with('categoriesWithCourses', $categoriesWithCourses);
        });
    }
}
