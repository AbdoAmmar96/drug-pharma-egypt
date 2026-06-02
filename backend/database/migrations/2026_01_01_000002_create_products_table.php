<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('form')->nullable(); // "Syrup 120ml", "Capsule", etc.
            $table->text('description')->nullable(); // short description
            $table->longText('composition')->nullable();
            $table->longText('uses')->nullable();
            $table->longText('dose')->nullable();
            $table->string('image')->nullable(); // storage path or URL
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['category_id', 'is_active']);
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
