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
            $table->id();
            $table->string('sku')->nullable();
            $table->text('title');
            $table->longText('description')->nullable();
            $table->decimal('price')->default(0)->nullable();
            $table->longText('seo')->nullable();
            $table->text('slug');
            $table->integer('sort')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Artisan::call('db:seed --class=ProductTableSeeder');
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
