<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$questions = App\Models\Question::all();
foreach($questions as $q) {
    $count = $q->answers()->where('is_correct', true)->count();
    if($count > 1) {
        $q->update(['type' => 'multiple_choice']);
        echo "Fixed Q: {$q->id}\n";
    }
}
echo "Done\n";
