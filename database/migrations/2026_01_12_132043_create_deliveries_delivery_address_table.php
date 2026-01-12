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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrier_id')->nullable()->constrained('carriers');
            $table->string('type', 50);
            $table->string('description', 200)->nullable(true);
            $table->integer('delivery_price');
            $table->timestamps();
        });

        Schema::create('delivery_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('delivery_id');
            $table->unsignedBigInteger('address_id');
            $table->timestamps();
            $table->foreign('delivery_id')->references('id')->on('deliveries');
            $table->foreign('address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('delivery_address');
    }
};
