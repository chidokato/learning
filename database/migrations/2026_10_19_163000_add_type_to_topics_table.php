<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('topics', 'type')) {
            Schema::table('topics', function (Blueprint $table) {
                $table->string('type', 50)->default('course')->after('id')->index()->comment('course: Topic khoa hoc, test: Topic bai kiem tra');
            });

            // Set existing topics to 'course'
            DB::table('topics')->update(['type' => 'course']);
        }

        // Clean up test_topic for course topics
        DB::table('test_topic')->truncate();
        if (Schema::hasColumn('tests', 'topic_id')) {
            DB::table('tests')->update(['topic_id' => null]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('topics', 'type')) {
            Schema::table('topics', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }
    }
};
