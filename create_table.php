<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasTable('homepage_categories')) {
    Schema::create('homepage_categories', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('svg_icon')->nullable();
        $table->string('link')->nullable();
        $table->integer('sort_order')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    echo 'Table homepage_categories created successfully.';
} else {
    echo 'Table homepage_categories already exists.';
}
