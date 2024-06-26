<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable(False);
            $table->string('email', 255)->nullable(False)->unique();
            $table->string('password', 255)->nullable(False);
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->timestamps();
        });
    } 

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
