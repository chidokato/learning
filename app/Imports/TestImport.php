<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class TestImport implements ToCollection
{
    protected $test_id;

    public function __construct($test_id)
    {
        $this->test_id = $test_id;
    }

    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        $currentQuestion = null;
        $order = 1;

        foreach ($rows as $index => $row) {
            // Bỏ qua dòng tiêu đề
            if ($index === 0) {
                continue;
            }

            $colA = isset($row[0]) ? trim($row[0]) : '';
            $colB = isset($row[1]) ? trim($row[1]) : '';
            $colC = isset($row[2]) ? trim($row[2]) : '';

            if (empty($colA) && empty($colB)) {
                continue; // Dòng trống
            }

            // Nếu Cột A có chữ "câu", đây là câu hỏi
            if (Str::startsWith(mb_strtolower($colA, 'UTF-8'), 'câu')) {
                $type = 'single_choice';
                
                // Kiểm tra xem là nhiều đáp án không
                if (Str::contains(mb_strtolower($colB, 'UTF-8'), 'nhiều') || Str::contains(mb_strtolower($colA, 'UTF-8'), 'nhiều')) {
                    $type = 'multiple_choice';
                }

                $currentQuestion = Question::create([
                    'test_id' => $this->test_id,
                    'content' => $colB,
                    'type'    => $type,
                    'order'   => $order++
                ]);
            } 
            // Nếu không phải là Câu, mà có đáp án A, B, C, D
            else if ($currentQuestion && preg_match('/^[A-Z]$/i', $colA)) {
                $is_correct = false;
                
                if (mb_strtolower($colC, 'UTF-8') === 'x' || $colC == '1' || mb_strtolower($colC, 'UTF-8') === 'đúng') {
                    $is_correct = true;
                }

                Answer::create([
                    'question_id' => $currentQuestion->id,
                    'label'       => strtoupper($colA),
                    'content'     => $colB,
                    'is_correct'  => $is_correct
                ]);
            }
            // Trường hợp user dùng "Nhiều đáp án" ở dòng riêng (cột A hoặc B) dưới câu hỏi
            else if ($currentQuestion && (Str::contains(mb_strtolower($colA, 'UTF-8'), 'nhiều') || Str::contains(mb_strtolower($colB, 'UTF-8'), 'nhiều'))) {
                 $currentQuestion->update(['type' => 'multiple_choice']);
            }
            
            // Xử lý auto detect: nếu nhiều đáp án đúng thì set multiple_choice
            if ($currentQuestion) {
                 $correctCount = Answer::where('question_id', $currentQuestion->id)->where('is_correct', true)->count();
                 if ($correctCount > 1) {
                     $currentQuestion->update(['type' => 'multiple_choice']);
                 }
            }
        }
    }
}
