<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\TestCase;

class CourseEmptyDataTest extends TestCase
{
    private function course(array $attributes = []): Post
    {
        return (new Post(array_merge([
            'title' => 'Course without sample data',
            'slug' => 'course-without-sample-data',
            'type' => Post::TYPE_COURSE,
        ], $attributes)))->setRelation('seller', null)->setRelation('category', null);
    }

    public function test_missing_pdf_does_not_resolve_to_another_courses_file(): void
    {
        $this->assertSame('', $this->course()->pdf_url);
        $this->assertSame('', $this->course(['pdf_file' => 'uploads/nonexistent-course-test.pdf'])->pdf_url);
    }

    public function test_empty_curriculum_renders_nothing(): void
    {
        $html = view('frontend.partials.course-curriculum', ['post' => $this->course()])->render();
        $this->assertSame('', trim($html));
    }

    public function test_course_card_does_not_invent_images_counts_or_instructors(): void
    {
        $html = view('frontend.partials.course-item', ['course' => $this->course()])->render();
        foreach (['<img', '12 Bài học', '50 Học viên', 'avatar-1-', 'seller->avatar)'] as $sample) {
            $this->assertStringNotContainsString($sample, $html);
        }
        $html = view('frontend.partials.course-item', ['course' => $this->course(['unit_count' => 7])])->render();
        $this->assertStringContainsString('7 Bài học', $html);
    }

    public function test_unknown_course_urls_return_not_found(): void
    {
        $this->get('/courses/nonexistent-course-empty-data-regression-739158')->assertNotFound();
        $this->get('/hoc-khoa-hoc/nonexistent-course-empty-data-regression-739158')->assertNotFound();
    }

    public function test_detail_preserves_saved_content_and_omits_missing_sections(): void
    {
        $html = view('frontend.course-details', [
            'post' => $this->course(['what_to_learn' => '<p>Saved learning outcomes</p>']),
            'relatedCourses' => collect(),
        ])->render();

        $this->assertStringContainsString('<p>Saved learning outcomes</p>', $html);
        foreach (['Khóa học này bao gồm:', 'Yêu cầu khóa học', 'Giảng viên phụ trách',
            'Indochine Instructor', '5,000+', 'Đánh giá xuất sắc', 'pQ9GnDx4Ozk',
            'Máy tính hoặc laptop', 'Hiểu sâu lý thuyết'] as $sample) {
            $this->assertStringNotContainsString($sample, $html);
        }
    }

    public function test_learning_tabs_have_no_fabricated_activity_or_attachments(): void
    {
        $html = view('frontend.course-learn', ['post' => $this->course()])->render();
        foreach (['Hoàng Minh', '128 lượt đánh giá', '4.8 MB', '12.4 MB',
            'thực hành thực tế.zip', 'headerProgressPercent', '<iframe', 'download class='] as $sample) {
            $this->assertStringNotContainsString($sample, $html);
        }
        $this->assertStringContainsString('id="tab-qa" role="tabpanel"></div>', $html);
        $this->assertStringContainsString('id="tab-reviews" role="tabpanel"></div>', $html);
    }
}
