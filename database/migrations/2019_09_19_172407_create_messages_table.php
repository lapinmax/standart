<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('chat_id')->unsigned();
            $table->foreign('chat_id')->references('id')->on('chats');

            $table->text('message');

            $table->enum('type', ['user', 'client', 'purchase']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down () {
        Schema::dropIfExists('messages');
    }
}
