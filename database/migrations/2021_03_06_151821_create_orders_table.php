<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('name');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('company')->nullable();
            $table->text('note')->nullable();
            $table->json('cart');
            $table->boolean('paid')->default(false);
            $table->float('price');
            $table->float('discount')->default(0);
            $table->string('status')->nullable();
            $table->enum('user_type', ['person', 'company']);
            $table->enum('delivery', ['delivery', 'pickup'])->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
