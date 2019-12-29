<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {
        Schema::create('rules', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->text('message')->nullable();
            $table->integer('days');
            $table->tinyInteger('active')->default(0);

            $table->integer('sort')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down () {
        Schema::dropIfExists('rules');
    }
}
