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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string("dui", 10)->unique();
            $table->string('email', 128)->unique();
            $table->string('password', 200);
            $table->string("name", 30);
            $table->string("lastname", 30);
            $table->date("birthdate");
            $table->integer("age");
            $table->string("address", 150);
            $table->string("phone", 40);
            $table->string("user_type_id", 3)->default("CLE");
            
            $table->foreign("user_type_id")->references('id')->on('users_types');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
