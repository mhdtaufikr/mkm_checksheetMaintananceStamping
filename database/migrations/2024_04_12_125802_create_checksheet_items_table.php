<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksheetItemsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('checksheet_items')) {
            Schema::create('checksheet_items', function (Blueprint $table) {
                $table->id('item_id');
                $table->foreignId('checksheet_id')->constrained('checksheets');
                $table->foreignId('machine_id')->constrained('machines');
                $table->string('item_name');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('checksheet_items');
    }
}
