<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElementLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('element_lists', function (Blueprint $table) {
            $table->id();
            $table->string('element_type')->nullable();
            $table->string('label_name')->nullable();
            $table->integer('form_id');
            $table->text('default_values')->nullable();
            $table->index(['form_id']);
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
        Schema::dropIfExists('element_lists');
    }
}
