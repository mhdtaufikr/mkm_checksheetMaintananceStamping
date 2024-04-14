<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksheetFormHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checksheet_form_heads', function (Blueprint $table) {
            $table->id();
            $table->string('department');
            $table->string('shop');
            $table->date('effective_date');
            $table->string('revision');
            $table->string('document_number');
            $table->string('op_number');
            $table->string('machine_name'); // Change from machine_id to machine_name
            $table->date('manufacturing_date');
            $table->string('process');
            $table->date('planning_date');
            $table->date('actual_date');
            $table->string('status');
            $table->string('created_by');
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
        Schema::dropIfExists('checksheet_form_heads');
    }
}
