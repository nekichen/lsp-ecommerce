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
            $table->string('invoice_number');
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->datetime('order_date');
            $table->foreignId('discount_id')->references('id')->on('discounts')->onDelete('cascade')->nullable();
            $table->double('total', 10, 2);
            $table->text('notes')->nullable();
            $table->enum('status', ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled']);
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
        Schema::dropIfExists('orders');
    }
}
