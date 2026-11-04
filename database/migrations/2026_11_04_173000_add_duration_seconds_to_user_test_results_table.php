<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('user_test_results') && !Schema::hasColumn('user_test_results', 'duration_seconds')) {
            Schema::table('user_test_results', function (Blueprint $table) {
                $table->unsignedInteger('duration_seconds')->nullable()->after('is_passed')->comment('Thời gian làm bài thực tế tính bằng giây');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('user_test_results') && Schema::hasColumn('user_test_results', 'duration_seconds')) {
            Schema::table('user_test_results', function (Blueprint $table) {
                $table->dropColumn('duration_seconds');
            });
        }
    }
};
