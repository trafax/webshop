<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->integer('required')->default(0);
            $table->integer('multiple')->default(0);
            $table->integer('selectable')->default(1);
            $table->integer('sort')->default(0)->nullable();
            $table->text('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Artisan::call('db:seed --class=FilterTableSeeder');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filters');
    }
}
