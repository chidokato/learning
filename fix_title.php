<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cats = \App\Models\HomepageCategory::all();
foreach($cats as $cat) {
    if(strpos($cat->title, '&amp;') !== false) {
        $cat->title = str_replace('&amp;', '&', $cat->title);
        $cat->save();
    }
}
echo "Fixed titles.";
