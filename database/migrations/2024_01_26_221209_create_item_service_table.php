<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemServiceTable extends Migration
{
    public function up(): void
    {
        Schema::create('item_service', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();

            $table->unsignedInteger('price')->nullable();
            $table->string('note', 255)->nullable();

            $table->unique(['item_id', 'service_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_service');
    }
}
