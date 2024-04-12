<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckSheetsTable extends Migration
{
    public function up()
    {
        Schema::create('checksheets', function (Blueprint $table) {
            $table->id('checksheet_id');
            $table->foreignId('machine_id')->constrained('machines');
            $table->string('checksheet_category');
            $table->string('checksheet_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checksheets');
    }
}
