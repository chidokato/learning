<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('homepage_categories', 'image')) {
    Schema::table('homepage_categories', function (Blueprint $table) {
        $table->string('image')->nullable()->after('svg_icon');
    });
    echo "Added image column.\n";
} else {
    echo "Column already exists.\n";
}
