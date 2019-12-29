<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoroscopesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {
        Schema::create('horoscopes', function (Blueprint $table) {
            $table->increments('id');

            $table->date('date')->nullable();

            $table->tinyInteger('filled')->default(0);

            $table->string('love_title')->nullable();
            $table->string('love_image')->nullable();
            $table->string('love_subtitle')->nullable();

            $table->string('overall_title')->nullable();
            $table->string('overall_image')->nullable();
            $table->string('overall_subtitle')->nullable();
            $table->text('overall_text')->nullable();

            $table->string('career_title')->nullable();
            $table->string('career_image')->nullable();
            $table->string('career_subtitle')->nullable();

            $table->string('health_title')->nullable();
            $table->string('health_image')->nullable();
            $table->string('health_subtitle')->nullable();

            $table->integer('lucky_number')->nullable();
            $table->text('lucky_human')->nullable();

            $table->integer('dream_sex')->nullable();
            $table->integer('dream_hustle')->nullable();
            $table->integer('dream_vibe')->nullable();
            $table->integer('dream_success')->nullable();

            $table->integer('biorhythms_physical_number')->nullable();
            $table->integer('biorhythms_intellectual_number')->nullable();
            $table->integer('biorhythms_emotional_number')->nullable();
            $table->integer('biorhythms_average_number')->nullable();

            $table->integer('zodiac_id')->unsigned();
            $table->foreign('zodiac_id')->references('id')->on('zodiacs');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down () {
        Schema::dropIfExists('horoscopes');
    }
}
