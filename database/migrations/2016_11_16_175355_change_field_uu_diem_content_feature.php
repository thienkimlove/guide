<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldUuDiemContentFeature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_feature', function (Blueprint $table) {
            $table->smallInteger('uu_diem')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content_feature', function (Blueprint $table) {
            $table->boolean('uu_diem')->default(true)->change();
        });
    }
}
