<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHoroscopesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {
        Schema::table('horoscopes', function (Blueprint $table) {
            $table->enum('type', ['day', 'year'])->default('day');
            $table->string('year')->nullable();
            $table->integer('template_id')->nullable()->unsigned();
            $table->foreign('template_id')->references('id')->on('push_templates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down () {
        //
    }
}
