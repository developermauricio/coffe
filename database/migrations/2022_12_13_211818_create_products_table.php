<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id_product');
            $table->string('product_name');
            $table->string('picture')->nullable();
            $table->mediumText('product_description');
            $table->string('reference');
            $table->double('price');
            $table->double('weight');
            $table->unsignedInteger('product_category_id')->nullable();;
            $table->foreign('product_category_id')->references('id_category')->on('categories');
            $table->integer('stock')->default(0);
            $table->string('product_slug');
            $table->softDeletes();
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
