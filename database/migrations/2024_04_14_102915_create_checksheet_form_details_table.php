<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksheetFormDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checksheet_form_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_header');
            $table->string('item_name');
            $table->string('checksheet_type');
            $table->string('spec')->nullable();
            $table->string('act')->nullable();
            $table->boolean('B')->default(0);
            $table->boolean('R')->default(0);
            $table->boolean('G')->default(0);
            $table->boolean('PP')->default(0);
            $table->string('judge')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('id_header')->references('id')->on('checksheet_headers')->onDelete('cascade');
            // You can add more foreign key constraints if needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checksheet_form_details');
    }
}
