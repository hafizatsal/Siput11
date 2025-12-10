<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users2', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('api_token');
            $table->string('password');
            $table->string('pass_default');
            $table->tinyInteger('pass_stat');
            $table->unsignedTinyInteger('id_role');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('status');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users2');
    }
}
