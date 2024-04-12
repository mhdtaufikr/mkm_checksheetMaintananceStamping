<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesTable extends Migration
{
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key column
            $table->string('machine_name');
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('machines');
    }
}

