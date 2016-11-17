<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCharacters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->smallInteger('ti_le_thang')->default(0);
            $table->smallInteger('ti_le_thua')->default(0);
            $table->smallInteger('ti_le_cam')->default(0);
            $table->smallInteger('ti_le_chon')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn([
                'ti_le_thang',
                'ti_le_thua',
                'ti_le_cam',
                'ti_le_chon'
            ]);
        });
    }
}
