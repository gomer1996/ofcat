<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkedCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linked_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->unsignedBigInteger('linked_category_id');
            $table->timestamps();

            $table->foreign('linked_category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linked_categories');
    }
}
