<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            $view->with('siteSetting', Cache::remember('site_setting', 1800, function () {
                return Setting::query()->firstOrCreate([]);
            }));
        });

        View::composer(['frontend.partials.header', 'frontend.layouts.app'], function ($view) {
            $view->with('headerMenus', Cache::remember('header_menus', 1800, function () {
                return Menu::query()
                    ->whereNull('parent_id')
                    ->active()
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->with('activeChildrenTree')
                    ->get();
            }));
        });

        View::composer('frontend.home', function ($view) {
            $categoriesWithCourses = Cache::remember('home_categories_with_courses', 600, function () {
                $categories = \App\Models\Category::query()
                    ->where('is_active', true)
                    ->whereHas('posts', function($query) {
                        $query->where('type', \App\Models\Post::TYPE_COURSE)->where('is_active', true);
                    })
                    ->orderBy('sort_order')
                    ->take(5) // Limit to avoid redundant queries
                    ->get();

                foreach ($categories as $category) {
                    $category->setRelation('posts', $category->posts()
                        ->where('type', Post::TYPE_COURSE)
                        ->where('is_active', true)
                        ->with(['category', 'seller'])
                        ->withCount('learningHistories')
                        ->latest('published_at')
                        ->latest('id')
                        ->take(4)
                        ->get());
                }

                return $categories;
            });

            $firstSlider = Cache::remember('home_first_slider', 600, function () {
                return \App\Models\Slider::where('is_active', true)->orderBy('sort_order')->first();
            });

            $view->with('categoriesWithCourses', $categoriesWithCourses)
                 ->with('firstSlider', $firstSlider);
        });
    }
}
