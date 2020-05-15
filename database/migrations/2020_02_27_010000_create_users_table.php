<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('login_id', 100);
            $table->string('hash_login_id', 100);
            $table->string('name', 1000);
            $table->string('email', 1000);
            $table->string('hash_email', 1000);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 10000);
            $table->foreignId('level_id')->constrained();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
