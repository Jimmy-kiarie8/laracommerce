<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
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
            $table->integer('user_id');
            $table->integer('brand_id');
            $table->integer('category_id');
            $table->integer('sub_id');
            $table->integer('price');
            $table->string('title');
            $table->integer('list_price')->nullable();
            $table->string('image')->nullable();
            $table->string('quantity_size')->nullable();
            $table->boolean('featured')->nullable();
            $table->boolean('deleted')->nullable();
            $table->string('sales')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
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
    }
}