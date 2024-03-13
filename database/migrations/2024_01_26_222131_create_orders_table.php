<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();

            $table->enum('payment_type', [1, 2])->default(1)->comment('1 => Cash, 2 => Deferred');
            $table->unsignedInteger('total_price')->nullable();
            $table->unsignedInteger('paid_money')->nullable();
            $table->unsignedInteger('remaining_money')->nullable();

            $table->boolean('has_deferred_payment')->default(false);

            $table->enum('status', [1, 2, 3, 4])->default(1)->comment('1 => Pending, 2 => PROCESSING, 3 => Completed, 4 => Cancelled ');
            $table->enum('payment_status', [1, 2])->default(2)->comment('1 => Paid, 2 => Unpaid');

            $table->foreignId('customer_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->boolean('created_by_customer')->default(false);

            $table->date('deliver_date')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
