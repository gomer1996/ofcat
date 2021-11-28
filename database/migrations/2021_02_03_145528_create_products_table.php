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
            $table->foreignId('category_id')->nullable()->constrained();
            $table->bigInteger('code')->nullable();
            $table->text('description')->nullable();
            $table->string('manufacturer')->nullable();
            $table->float('weight')->nullable();
            $table->float('volume')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('barcode')->nullable();
            $table->string('vendor_code')->nullable();
            $table->string('outer_id')->nullable();
            $table->foreignId('integration_category_id')->nullable()->constrained();
            $table->enum('integration', ['samson', 'relef'])->nullable();
            $table->json('properties')->nullable();

            $table->boolean('is_hit')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('ignore_tax')->default(false);
            $table->bigInteger('stock')->default(0);

            $table->timestamps();

            $table->index('barcode');
            $table->index('vendor_code');
            $table->index('code');
            $table->index('outer_id');
            $table->index('brand');
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
