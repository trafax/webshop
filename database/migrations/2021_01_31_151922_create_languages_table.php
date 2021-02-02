<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('iso');
            $table->integer('sort')->default(0);
            $table->tinyInteger('default')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();
        });

        Artisan::call('db:seed --class=LanguageTableSeeder');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
