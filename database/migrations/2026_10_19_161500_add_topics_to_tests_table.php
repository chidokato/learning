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
        if (!Schema::hasColumn('tests', 'topic_id')) {
            Schema::table('tests', function (Blueprint $table) {
                $table->unsignedBigInteger('topic_id')->nullable()->after('post_id')->comment('Topic/Muc chinh cua bai test');
                $table->foreign('topic_id')->references('id')->on('topics')->nullOnDelete();
            });
        }

        if (!Schema::hasTable('test_topic')) {
            Schema::create('test_topic', function (Blueprint $table) {
                $table->id();
                $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
                $table->foreignId('topic_id')->constrained('topics')->cascadeOnDelete();
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
        Schema::dropIfExists('test_topic');

        if (Schema::hasColumn('tests', 'topic_id')) {
            Schema::table('tests', function (Blueprint $table) {
                $table->dropForeign(['topic_id']);
                $table->dropColumn('topic_id');
            });
        }
    }
};
