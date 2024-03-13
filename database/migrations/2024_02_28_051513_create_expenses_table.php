<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', [1, 2, 3])->comment('1 => Salary, 2 => Orders, 3 => Others');
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedDecimal('value');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
