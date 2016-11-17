<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldManhHonCharacterContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('character_content', function (Blueprint $table) {
            $table->smallInteger('manh_hon')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('character_content', function (Blueprint $table) {
            $table->boolean('manh_hon')->default(true)->change();
        });
    }
}
