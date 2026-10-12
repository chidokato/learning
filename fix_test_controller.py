import sys

path = "app/Http/Controllers/TestController.php"
with open(path, "r", encoding="utf-8") as f:
    content = f.read()

import re
pattern = r"// Lu kt qu vAo DB.*?\]\);"
replacement = """// Lưu kết quả vào DB
        $user_id = auth()->id() ?? 1;

        $result = UserTestResult::updateOrCreate(
            [
                'user_id' => $user_id,
                'test_id' => $test_id,
            ],
            [
                'score' => $totalCorrect,
                'is_passed' => $isPassed,
                'completed_at' => now(),
            ]
        );"""

content = re.sub(pattern, replacement, content, flags=re.DOTALL)
with open(path, "w", encoding="utf-8") as f:
    f.write(content)
