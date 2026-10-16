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
        if (!Schema::hasColumn('posts', 'allow_download_pdf')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->boolean('allow_download_pdf')->default(false)->after('pdf_file');
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
        if (Schema::hasColumn('posts', 'allow_download_pdf')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('allow_download_pdf');
            });
        }
    }
};
