<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicsTable extends Migration
{
    public function up()
    {
        Schema::create('publics', function (Blueprint $table) {
            $table->id();
            $table->string('vk_id');
            $table->string('name');
            $table->string('token');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('publics');
    }
}
