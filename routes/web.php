<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

$postDetailHandler = function (string $slug) {
    $cleanSlug = trim(urldecode($slug));

    $post = \App\Models\Post::query()
        ->where(function ($query) use ($cleanSlug) {
            $query->where('slug', $cleanSlug)
                ->orWhere('slug', 'like', '%' . $cleanSlug . '%')
                ->orWhere('title', 'like', '%' . str_replace('-', ' ', $cleanSlug) . '%');
        })
        ->with(['category', 'seller'])
        ->first();

    if (! $post) {
        $post = \App\Models\Post::query()
            ->whereIn('type', [\App\Models\Post::TYPE_COURSE, \App\Models\Post::TYPE_PRODUCT])
            ->where('is_active', true)
            ->with(['category', 'seller'])
            ->latest('published_at')
            ->first();
    }

    if (! $post) {
        $post = new \App\Models\Post([
            'title' => 'Design Thinking Researching for Better UX',
            'slug' => $cleanSlug ?: 'design-thinking-researching-for-better-ux',
            'summary' => 'This course takes you from beginner to advanced developer. Learn modern skills and build real-world projects.',
            'content' => '<p>Throughout this course, you will work on hands-on projects and gain confidence to build complex applications from scratch.</p>',
            'price' => 500000,
            'type' => 'course',
            'is_active' => true,
        ]);
    }

    $relatedCourses = \App\Models\Post::query()
        ->whereIn('type', [\App\Models\Post::TYPE_COURSE, \App\Models\Post::TYPE_PRODUCT])
        ->where('is_active', true)
        ->when($post->id, function ($query) use ($post) {
            $query->where('id', '!=', $post->id);
        })
        ->when($post->category_id, function ($query) use ($post) {
            $query->where('category_id', $post->category_id);
        })
        ->latest('published_at')
        ->take(4)
        ->get();

    return view('frontend.course-details', compact('post', 'relatedCourses'));
};

$courseLearnHandler = function (string $slug) {
    $cleanSlug = trim(urldecode($slug));

    $post = \App\Models\Post::query()
        ->where(function ($query) use ($cleanSlug) {
            $query->where('slug', $cleanSlug)
                ->orWhere('slug', 'like', '%' . $cleanSlug . '%')
                ->orWhere('title', 'like', '%' . str_replace('-', ' ', $cleanSlug) . '%');
        })
        ->with(['category', 'seller'])
        ->first();

    if (! $post) {
        $post = \App\Models\Post::query()
            ->whereIn('type', [\App\Models\Post::TYPE_COURSE, \App\Models\Post::TYPE_PRODUCT])
            ->where('is_active', true)
            ->with(['category', 'seller'])
            ->latest('published_at')
            ->first();
    }

    if (! $post) {
        $post = new \App\Models\Post([
            'title' => 'Design Thinking Researching for Better UX',
            'slug' => $cleanSlug ?: 'design-thinking-researching-for-better-ux',
            'summary' => 'This React course takes you from beginner to advanced developer. Learn modern React, hooks, state management, and build real-world projects.',
            'content' => '<p>Throughout this course, you will work on hands-on projects including a social media app, e-commerce platform, and task management system.</p>',
            'price' => 500000,
            'type' => 'course',
            'is_active' => true,
        ]);
    }

    return view('frontend.course-learn', compact('post'));
};

$fallbackCourseDetailHandler = function () {
    $post = \App\Models\Post::query()
        ->where('type', \App\Models\Post::TYPE_COURSE)
        ->where('is_active', true)
        ->with(['category', 'seller'])
        ->latest('published_at')
        ->first();

    if (! $post) {
        $post = new \App\Models\Post([
            'title' => 'Design Thinking Researching for Better UX',
            'slug' => 'design-thinking-researching-for-better-ux',
            'summary' => 'This React course takes you from beginner to advanced developer. Learn modern React, hooks, state management, and build real-world projects.',
            'content' => '<p>Throughout this course, you will work on hands-on projects including a social media app, e-commerce platform, and task management system. By the end, you will have the confidence to build complex React applications from scratch.</p>',
            'price' => 500000,
            'type' => 'course',
            'is_active' => true,
        ]);
    }

    $relatedCourses = \App\Models\Post::query()
        ->where('type', \App\Models\Post::TYPE_COURSE)
        ->where('is_active', true)
        ->when($post->id, function ($query) use ($post) {
            $query->where('id', '!=', $post->id);
        })
        ->take(4)
        ->get();

    return view('frontend.course-details', compact('post', 'relatedCourses'));
};

Route::get('/', fn () => view('frontend.home'))->name('frontend.home');
Route::get('courses-v1.html', fn () => view('frontend.home'));
Route::get('courses-details-v2.html', $fallbackCourseDetailHandler)->name('frontend.courses.details.demo');
Route::get('courses/{slug}/hoc', fn (string $slug) => $courseLearnHandler($slug))->name('frontend.course.learn.prefix');
Route::get('hoc-khoa-hoc/{slug}', fn (string $slug) => $courseLearnHandler($slug))->name('frontend.course.learn');
Route::get('courses/{slug}', fn (string $slug) => $postDetailHandler($slug))->name('frontend.courses.show');
Route::get('products/{slug}', fn (string $slug) => $postDetailHandler($slug))->name('frontend.products.show.legacy');
Route::get('news/{slug}', fn () => view('frontend.home'))->name('frontend.news.show.legacy');


Route::prefix('admin')->name('backend.')->group(function () {
    Route::controller(AdminController::class)->name('admin.')->group(function () {
        Route::get('/', 'dashboard')->name('dashboard');
        Route::get('login', 'login')->name('login');
        Route::post('login', 'authenticate')->name('authenticate');
        Route::post('logout', 'logout')->name('logout');
        Route::post('uploads/editor-image', fn () => response()->json([
            'url' => asset('admin-assets/images/logo-sm.png'),
        ]))->name('uploads.editor-image');
    });

    $redirectToDashboard = fn () => redirect()->route('backend.admin.dashboard');

    Route::controller(PostController::class)->group(function () {
        Route::get('news', 'index')->name('news.index')->defaults('type', 'news');
        Route::get('news/create', 'create')->name('news.create')->defaults('type', 'news');
        Route::post('news', 'store')->name('news.store')->defaults('type', 'news');
        Route::get('news/{post}/edit', 'edit')->name('news.edit')->defaults('type', 'news');
        Route::put('news/{post}', 'update')->name('news.update')->defaults('type', 'news');
        Route::delete('news/{post}', 'destroy')->name('news.destroy')->defaults('type', 'news');
        Route::patch('news/{post}/toggle-status', 'toggleStatus')->name('news.toggle-status')->defaults('type', 'news');

        Route::get('courses', 'index')->name('courses.index')->defaults('type', 'course');
        Route::get('courses/create', 'create')->name('courses.create')->defaults('type', 'course');
        Route::post('courses', 'store')->name('courses.store')->defaults('type', 'course');
        Route::get('courses/{post}/edit', 'edit')->name('courses.edit')->defaults('type', 'course');
        Route::put('courses/{post}', 'update')->name('courses.update')->defaults('type', 'course');
        Route::delete('courses/{post}', 'destroy')->name('courses.destroy')->defaults('type', 'course');
        Route::patch('courses/{post}/toggle-status', 'toggleStatus')->name('courses.toggle-status')->defaults('type', 'course');
        Route::patch('courses/{post}/toggle-featured', 'toggleFeatured')->name('courses.toggle-featured')->defaults('type', 'course');

        Route::get('products', fn () => redirect()->route('backend.courses.index'))->name('products.index');
        Route::get('products/create', fn () => redirect()->route('backend.courses.create'))->name('products.create');
    });

    Route::get('customer-inquiries', $redirectToDashboard)->name('customer-inquiries.index');
    Route::get('seo', $redirectToDashboard)->name('seo.edit');

    Route::controller(CategoryController::class)->group(function () {
        Route::get('categories', 'index')->name('categories.index');
        Route::get('categories/create', 'create')->name('categories.create');
        Route::post('categories', 'store')->name('categories.store');
        Route::get('categories/{category}/edit', 'edit')->name('categories.edit');
        Route::put('categories/{category}', 'update')->name('categories.update');
        Route::delete('categories/{category}', 'destroy')->name('categories.destroy');
        Route::patch('categories/{category}/toggle-status', 'toggleStatus')->name('categories.toggle-status');
        Route::patch('categories/{category}/sort-order', 'updateSortOrder')->name('categories.update-sort-order');
    });

    Route::controller(MenuController::class)->group(function () {
        Route::get('menus', 'index')->name('menus.index');
        Route::get('menus/create', 'create')->name('menus.create');
        Route::post('menus', 'store')->name('menus.store');
        Route::get('menus/{menu}/edit', 'edit')->name('menus.edit');
        Route::put('menus/{menu}', 'update')->name('menus.update');
        Route::delete('menus/{menu}', 'destroy')->name('menus.destroy');
        Route::patch('menus/{menu}/toggle-status', 'toggleStatus')->name('menus.toggle-status');
        Route::patch('menus/{menu}/sort-order', 'updateSortOrder')->name('menus.update-sort-order');
    });

    Route::controller(SettingController::class)->group(function () {
        Route::get('settings', 'edit')->name('settings.edit');
        Route::put('settings', 'update')->name('settings.update');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'index')->name('users.index');
        Route::get('users/create', 'create')->name('users.create');
        Route::post('users', 'store')->name('users.store');
        Route::get('users/{user}/edit', 'edit')->name('users.edit');
        Route::put('users/{user}', 'update')->name('users.update');
        Route::delete('users/{user}', 'destroy')->name('users.destroy');
    });
});

$categoryHandler = function (string $categorySlug) use ($postDetailHandler) {
    $category = \App\Models\Category::query()
        ->where('slug', $categorySlug)
        ->where('is_active', true)
        ->first();

    if (! $category) {
        $menu = \App\Models\Menu::query()
            ->where('slug', $categorySlug)
            ->where('is_active', true)
            ->first();
        if ($menu) {
            $category = \App\Models\Category::query()
                ->where('slug', $categorySlug)
                ->orWhere('name', 'LIKE', $menu->name)
                ->where('is_active', true)
                ->first();
            if (! $category) {
                $category = new \App\Models\Category([
                    'name' => $menu->name,
                    'slug' => $menu->slug,
                    'type' => \App\Models\Category::TYPE_COURSE,
                    'is_active' => true,
                ]);
            }
        }
    }

    if (! $category) {
        $post = \App\Models\Post::query()
            ->where('slug', $categorySlug)
            ->where('is_active', true)
            ->first();

        if ($post) {
            return $postDetailHandler($categorySlug);
        }

        abort(404);
    }

    $categoryIds = [$category->id];
    if ($category->exists) {
        $childIds = \App\Models\Category::query()
            ->where('parent_id', $category->id)
            ->where('is_active', true)
            ->pluck('id')
            ->toArray();
        $categoryIds = array_merge($categoryIds, $childIds);
    }

    $courses = \App\Models\Post::query()
        ->where('type', \App\Models\Post::TYPE_COURSE)
        ->where('is_active', true)
        ->when($category->exists, function ($query) use ($categoryIds) {
            $query->whereIn('category_id', $categoryIds);
        })
        ->with(['category', 'seller'])
        ->latest('published_at')
        ->latest('id')
        ->paginate(9);

    return view('frontend.category', compact('category', 'courses'));
};

Route::get('danh-muc/{categorySlug}', $categoryHandler)->name('frontend.category.show.prefix');
Route::get('danh-muc/{categorySlug}/{slug}/hoc', fn (string $categorySlug, string $slug) => $courseLearnHandler($slug))->name('frontend.course.learn.category.prefix');
Route::get('danh-muc/{categorySlug}/{slug}', fn (string $categorySlug, string $slug) => $postDetailHandler($slug))->name('frontend.category.content.show.prefix');
Route::get('category/{categorySlug}', $categoryHandler);
Route::get('category/{categorySlug}/{slug}/hoc', fn (string $categorySlug, string $slug) => $courseLearnHandler($slug));
Route::get('category/{categorySlug}/{slug}', fn (string $categorySlug, string $slug) => $postDetailHandler($slug));
Route::get('{categorySlug}', $categoryHandler)
    ->where('categorySlug', '(?!admin|api|assets|storage|vendor|login|logout|register|password|email|courses-v1\.html|courses-details-v2\.html)[^/]+')
    ->name('frontend.category.show');

Route::get('{categorySlug}/{slug}/hoc', fn (string $categorySlug, string $slug) => $courseLearnHandler($slug))
    ->where('categorySlug', '(?!admin|api|assets|storage|vendor)[^/]+')
    ->name('frontend.course.learn.category');

Route::get('{categorySlug}/{slug}', fn (string $categorySlug, string $slug) => $postDetailHandler($slug))
    ->where('categorySlug', '(?!admin|api|assets|storage|vendor)[^/]+')
    ->name('frontend.content.show');

