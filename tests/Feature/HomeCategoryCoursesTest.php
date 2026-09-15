<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HomeCategoryCoursesTest extends TestCase
{
    use DatabaseTransactions;

    public function test_each_home_category_gets_its_own_three_latest_active_courses(): void
    {
        $expected = [];
        foreach (['first', 'second'] as $group) {
            $category = Category::create([
                'name' => 'Regression '.$group,
                'slug' => 'regression-home-'.$group,
                'type' => Category::TYPE_COURSE,
                'is_active' => true,
            ]);
            $ids = [];
            foreach (range(1, 4) as $number) {
                $ids[] = Post::create([
                    'category_id' => $category->id,
                    'title' => 'Regression '.$group.' '.$number,
                    'slug' => 'regression-home-'.$group.'-'.$number,
                    'type' => Post::TYPE_COURSE,
                    'is_active' => true,
                    'is_featured' => false,
                    'published_at' => '2026-01-01 00:00:00',
                ])->id;
            }
            foreach (['inactive', 'news'] as $excluded) {
                Post::create([
                    'category_id' => $category->id,
                    'title' => 'Excluded '.$group.' '.$excluded,
                    'slug' => 'regression-home-'.$group.'-'.$excluded,
                    'type' => $excluded === 'news' ? Post::TYPE_NEWS : Post::TYPE_COURSE,
                    'is_active' => $excluded !== 'inactive',
                    'published_at' => '2026-02-01 00:00:00',
                ]);
            }
            $expected[$category->id] = array_slice(array_reverse($ids), 0, 3);
        }

        $view = view('frontend.home');
        $html = $view->render();
        $categories = $view->getData()['categoriesWithCourses']->keyBy('id');
        foreach ($expected as $categoryId => $ids) {
            $posts = $categories[$categoryId]->posts;
            $this->assertSame($ids, $posts->modelKeys());
            foreach ($posts as $post) {
                $this->assertStringContainsString($post->title, $html);
            }
        }
    }
}
