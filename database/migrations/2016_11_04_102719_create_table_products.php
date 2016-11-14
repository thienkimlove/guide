<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');

            //general
            $table->string('title', 255);
            $table->string('seo_title', 255)->nullable();
            $table->string('slug', 200)->unique();
            $table->text('desc')->nullable();
            $table->text('keywords')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('views')->default(0);

            //special

            $table->text('content_tab1');
            $table->text('content_tab2');
            $table->text('content_tab3');
            $table->text('congdung')->nullable();
            $table->string('xuatxu')->nullable();
            $table->string('giayphep')->nullable();
            $table->string('quycach')->nullable();
            $table->string('tinhtrang')->nullable();
            $table->string('giacu')->nullable();
            $table->string('giamoi')->nullable();

            $table->timestamps();
        });

        Schema::create('product_tag', function(Blueprint $tale)
        {
            $tale->integer('product_id')->unsigned()->index();
            $tale->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $tale->integer('tag_id')->unsigned()->index();
            $tale->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_tag');
    }
}
