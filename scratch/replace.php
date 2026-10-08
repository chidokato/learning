<?php
$c = file_get_contents("routes/web.php");
$target = "return view('frontend.course-learn', compact('post'));";
$insertion = "if (auth()->check()) {\n        \$userId = auth()->id();\n        \$cacheKey = \"user_{\$userId}_learned_post_{\$post->id}\";\n        if (!cache()->has(\$cacheKey)) {\n            \$post->increment('view_count');\n            cache()->put(\$cacheKey, true, now()->addYears(10));\n        }\n    } else {\n        \$sessionKey = \"guest_learned_post_{\$post->id}\";\n        if (!session()->has(\$sessionKey)) {\n            \$post->increment('view_count');\n            session()->put(\$sessionKey, true);\n        }\n    }\n\n    " . $target;

$c = str_replace($target, $insertion, $c);
file_put_contents("routes/web.php", $c);
