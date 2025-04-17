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
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('cus_name')->nullable();
            $table->string('cus_add')->nullable();
            $table->string('cus_state')->nullable();
            $table->string('cus_city')->nullable();
            $table->string('cus_postcode')->nullable();
            $table->string('cus_country')->nullable();
            $table->string('cus_phone')->nullable();
            $table->string('cus_fax')->nullable();
            $table->string('ship_name')->nullable();
            $table->string('ship_add')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_state')->nullable();
            $table->string('ship_postcode')->nullable();
            $table->string('ship_country')->nullable();
            $table->string('ship_phone')->nullable();
            $table->foreignId('user_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_profiles');
    }
};
