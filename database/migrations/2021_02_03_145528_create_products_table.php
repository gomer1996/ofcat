<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price');
            $table->string('brand')->nullable();
            $table->foreignId('category_id')->constrained();
            $table->bigInteger('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('manufacturer')->nullable();
            $table->float('weight')->nullable();
            $table->float('volume')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('barcode')->unique()->nullable();
            $table->string('vendor_code')->unique()->nullable();
            $table->string('relef_guid')->unique()->nullable();
            $table->bigInteger('samson_sku')->unique()->nullable();
            $table->json('properties')->nullable();

            $table->boolean('is_hit')->default(false);

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
        Schema::dropIfExists('products');
    }
}
