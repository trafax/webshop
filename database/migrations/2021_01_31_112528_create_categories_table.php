<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default(0);
            $table->text('title');
            $table->longText('description')->nullable();
            $table->string('slug');
            $table->longText('seo')->nullable();
            $table->integer('sort')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Artisan::call('db:seed --class=CategoryTableSeeder');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
