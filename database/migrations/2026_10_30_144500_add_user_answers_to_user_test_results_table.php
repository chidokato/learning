<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_test_results', function (Blueprint $table) {
            $table->json('user_answers')->nullable()->after('completed_at');
        });
    }

    public function down()
    {
        Schema::table('user_test_results', function (Blueprint $table) {
            $table->dropColumn('user_answers');
        });
    }
};
