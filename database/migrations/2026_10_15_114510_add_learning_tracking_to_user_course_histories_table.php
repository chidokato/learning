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
        Schema::table('user_course_histories', function (Blueprint $table) {
            $table->unsignedInteger('study_time_seconds')->default(0)->after('last_learned_at');
            $table->unsignedInteger('current_page')->default(1)->after('study_time_seconds');
            $table->unsignedInteger('total_pages')->default(0)->after('current_page');
            $table->unsignedTinyInteger('progress_percent')->default(0)->after('total_pages');
            $table->timestamp('completed_at')->nullable()->after('progress_percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_course_histories', function (Blueprint $table) {
            $table->dropColumn([
                'study_time_seconds',
                'current_page',
                'total_pages',
                'progress_percent',
                'completed_at',
            ]);
        });
    }
};
