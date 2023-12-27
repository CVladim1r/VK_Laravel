<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestsTable extends Migration
{
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->binary('image')->nullable();
            $table->text('text');
            $table->dateTime('draw_time');
            $table->string('public_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contests');
    }
}
