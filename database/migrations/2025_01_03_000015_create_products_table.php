<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('url_key')->nullable();
            $table->string('description')->nullable();
            $table->string('short_description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('new')->nullable();
            $table->boolean('featured')->nullable();
            $table->decimal('price', 12, 3)->default(0);
            $table->decimal('special_price', 12, 3)->default(0);
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });

        Schema::create('product_up_sells', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('child_id')->constrained('products')->cascadeOnDelete();
            $table->index(['parent_id', 'child_id']);
        });

        Schema::create('product_cross_sells', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('child_id')->constrained('products')->cascadeOnDelete();
            $table->index(['parent_id', 'child_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_up_sells');
        Schema::dropIfExists('product_cross_sells');
        Schema::dropIfExists('products');
    }
};
