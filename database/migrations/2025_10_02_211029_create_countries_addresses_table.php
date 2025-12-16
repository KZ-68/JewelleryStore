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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('local');
            $table->string('iso');
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->foreignId('manufacturer_id')->nullable()->constrained('manufacturers');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
            $table->string('address_line_1', 255)->nullable();
            $table->string('address_line_2', 255)->nullable();
            $table->string('city', 200)->nullable();            
            $table->string('postal_code', 10)->nullable();
            $table->string('region', 255)->nullable();
            $table->string("district", 255)->nullable();
            $table->string("sub_district", 255)->nullable();
            $table->string("locality", 255)->nullable();
            $table->string("sub_locality", 255)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
        Schema::dropIfExists('addresses');
    }
};
