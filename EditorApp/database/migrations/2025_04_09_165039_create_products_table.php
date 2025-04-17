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
            $table->string('title', 200);
            $table->string('short_des', 500);
            $table->decimal('price', 8, 2);
            $table->boolean('is_discount')->default(false);
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->string('image', 200);
            $table->boolean('in_stock')->default(true);
            $table->integer('stock')->default(0);
            $table->float('star')->default(0);
            $table->enum('remark', ['popular', 'new', 'top', 'special', 'trending', 'regular'])->default('regular');
            $table->foreignId('category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('brand_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
