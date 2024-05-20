<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {

        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255)->nullable(False);
                $table->text('description');
                $table->integer('price')->nullable(False);
                $table->string('image', 255);
                $table->unsignedBigInteger('category_id')->nullable(False);
                $table->date('expired_at')->nullable(False);
                $table->string('modified_by', 255)->nullable(False)->comment('email user');
                $table->timestamps();          
            }); 
        }
    }
    
    public function down()
    {
         Schema::dropIfExists('products');
    }
};
