<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntegrationCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integration_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('level', [1,2,3,4,5])->nullable();
            $table->string('outer_id')->unique();
            $table->string('outer_parent_id')->nullable();
            $table->enum('integration', ['relef']);
            $table->timestamps();

            $table->index('outer_id');
            $table->index('outer_parent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('integration_categories');
    }
}
