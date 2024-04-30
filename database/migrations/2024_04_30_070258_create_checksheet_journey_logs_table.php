<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksheetJourneyLogsTable extends Migration
{
    public function up()
    {
        Schema::create('checksheet_journey_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checksheet_id');
            $table->unsignedBigInteger('user_id');
            $table->string('action'); // approve, remand, etc.
            $table->text('remark')->nullable();
            $table->timestamps();

            $table->foreign('checksheet_id')->references('id')->on('checksheet_form_details')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('checksheet_journey_logs');
    }
}

