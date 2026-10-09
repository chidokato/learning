<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('homepage_categories', 'color')) {
    Schema::table('homepage_categories', function (Blueprint $table) {
        $table->string('color', 20)->nullable()->after('title');
    });
    echo "Added color column.\n";
    
    // Let's seed the existing colors based on item-style 1-8
    $colors = [
        '#0ab99d', // style-1 (default theme 1 is often #0ab99d)
        '#f8c62f', // style-2 Arts & Design (yellow)
        '#FF4D4F', // style-3 Health & Fitness (red)
        '#3D97FE', // style-4 Personal Dev (blue)
        '#2F57EF', // style-5 Video (purple-blue)
        '#39B410', // style-6 Comp Sci (green)
        '#8E56FF', // style-7 Digital Mark (purple)
        '#F92596', // style-8 Data Sci (pink)
    ];
    
    $cats = \App\Models\HomepageCategory::orderBy('sort_order')->get();
    foreach($cats as $i => $cat) {
        $c = $colors[$i % count($colors)];
        $cat->update(['color' => $c]);
    }
    echo "Seeded colors.\n";
} else {
    echo "Column already exists.\n";
}
