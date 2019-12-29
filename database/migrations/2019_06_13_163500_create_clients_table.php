<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('confirmation_token')->nullable();

            $table->string('gender')->nullable();
            $table->string('favoriteColor')->nullable();
            $table->integer('favoriteNumber')->nullable();

            $table->string('socialType')->nullable();
            $table->text('socialToken')->nullable();
            $table->string('socialProfileID')->unique()->nullable();

            $table->string('type')->nullable();

            $table->tinyInteger('active')->default(0);

            $table->string("name")->nullable();
            $table->string("relationships")->nullable();

            $table->string("sign")->nullable();
            $table->boolean("three_questions")->default(false);
            $table->boolean("five_questions")->default(false);
            $table->boolean("ten_questions")->default(false);

            $table->date("birthday")->nullable();
            $table->date("partner_birthday")->nullable();
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
        Schema::dropIfExists('clients');
    }
}
