<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilterProductPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filter_id')->index();
            $table->foreign('filter_id')->references('id')->on('filters')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->index();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // $table->primary(['filter_id', 'product_id']);
            $table->text('title')->nullable();
            $table->decimal('price')->default(0)->nullable();
            $table->decimal('price_extra')->default(0)->nullable();
            $table->integer('sort')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filter_product');
    }
}
