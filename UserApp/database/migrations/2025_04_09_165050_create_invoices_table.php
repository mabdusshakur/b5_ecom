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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 8, 2);
            $table->decimal('vat', 8, 2);
            $table->decimal('payable', 8, 2);
            $table->string('cus_details', 500);
            $table->string('ship_details', 500);
            $table->string('tran_id', 100);
            $table->string('val_id', 100)->default(0);
            $table->enum('delivery_status', ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled']);
            $table->enum('payment_status', ['Pending', 'Success', 'Fail', 'Cancel']);
            $table->foreignId('customer_id')->references('id')->on('customer_profiles')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
