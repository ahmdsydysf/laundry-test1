<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            $table->foreignId('item_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();

            $table->unsignedInteger('price')->nullable();
            $table->unsignedSmallInteger('quantity');
            $table->unsignedInteger('total_price')->nullable();
            $table->boolean('is_payment_deferred')->default(false);

            $table->mediumText('description')->nullable();

            $table->unique(['order_id', 'item_id', 'quantity']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
}

