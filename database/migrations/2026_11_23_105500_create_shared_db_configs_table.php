<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('shared_db_configs')) {
            Schema::create('shared_db_configs', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique();
                $table->string('driver')->default('mysql');
                $table->string('host')->default('127.0.0.1');
                $table->unsignedInteger('port')->default(3306);
                $table->string('database');
                $table->string('username');
                $table->text('password')->nullable();
                $table->string('table_name');
                $table->string('prefix')->nullable();
                $table->string('charset')->default('utf8mb4');
                $table->string('collation')->default('utf8mb4_unicode_ci');
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shared_db_configs');
    }
};
