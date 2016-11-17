<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('slug');

            $table->integer('character_id')->unsigned();
            $table->foreign('character_id')
                ->references('id')
                ->on('characters')
                ->onDelete('cascade');

            $table->integer('position_id')->unsigned();
            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onDelete('cascade');

            $table->string('table_support_1')->nullable();
            $table->string('table_support_2')->nullable();
            $table->string('table_support_3')->nullable();

            $table->text('giai_doan_dau_tran')->nullable();
            $table->text('giai_doan_giua_tran')->nullable();
            $table->text('giai_doan_cuoi_tran')->nullable();

            $table->timestamps();
        });

        Schema::create('content_supplement', function(Blueprint $table)
        {
            $table->integer('content_id')->unsigned()->index();
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
            $table->integer('supplement_id')->unsigned()->index();
            $table->foreign('supplement_id')->references('id')->on('supplements')->onDelete('cascade');

            $table->smallInteger('number')->default(0);
        });

        Schema::create('content_equipment', function(Blueprint $table)
        {
            $table->integer('content_id')->unsigned()->index();
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
            $table->integer('equipment_id')->unsigned()->index();
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');

            $table->enum('type', ['khoi_dau', 'lan_ve_dau_tien', 'tran_phai', 'hoan_chinh', 'tuy_chon']);

        });

        Schema::create('content_skill', function(Blueprint $table)
        {
            $table->integer('content_id')->unsigned()->index();
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
            $table->integer('skill_id')->unsigned()->index();
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');

            $table->smallInteger('step');

        });

        Schema::create('content_support', function(Blueprint $table)
        {
            $table->integer('content_id')->unsigned()->index();
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
            $table->integer('support_id')->unsigned()->index();
            $table->foreign('support_id')->references('id')->on('supports')->onDelete('cascade');

            $table->enum('type', ['chinh', 'tinh_huong']);

        });

        Schema::create('character_content', function(Blueprint $table)
        {
            $table->integer('content_id')->unsigned()->index();
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
            $table->integer('character_id')->unsigned()->index();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');

            $table->boolean('manh_hon')->default(true);
        });

        Schema::create('content_feature', function(Blueprint $table)
        {
            $table->integer('content_id')->unsigned()->index();
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
            $table->integer('feature_id')->unsigned()->index();
            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');

            $table->boolean('uu_diem')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
