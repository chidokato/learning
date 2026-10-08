<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

if (!Schema::hasTable('sliders')) {
    Schema::create('sliders', function (Blueprint $table) {
        $table->id();
        $table->string('title')->nullable();
        $table->string('subtitle')->nullable();
        $table->string('button_text')->nullable();
        $table->string('button_link')->nullable();
        $table->string('image')->nullable();
        $table->integer('sort_order')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    echo "Table created successfully.\n";
} else {
    echo "Table already exists.\n";
}
