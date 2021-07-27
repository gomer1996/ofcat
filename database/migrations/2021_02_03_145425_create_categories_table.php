<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('parent_id')->nullable();
            $table->enum('level', [1,2,3,4,5])->nullable();
            $table->integer('order')->default(0);
            $table->string('img')->nullable();
            $table->float('discount')->default(0);
            $table->float('tax')->default(0);
            $table->string('samson_id')->unique()->nullable();
            $table->string('samson_parent_id')->nullable();
            $table->timestamps();

            $table->index('parent_id');
            $table->index('samson_id');
            $table->index('samson_parent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
