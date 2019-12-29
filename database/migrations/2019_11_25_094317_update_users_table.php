<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('is_admin')->default(0);
            $table->tinyInteger('horoscopes')->default(0);
            $table->tinyInteger('clients')->default(0);
            $table->tinyInteger('chats')->default(0);
            $table->tinyInteger('templates')->default(0);
            $table->tinyInteger('users')->default(0);
            $table->tinyInteger('rules')->default(0);
            $table->softDeletes();
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
