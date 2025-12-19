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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_customer')->constrained('customers');
            $table->string('seller_code')->unique();
            $table->timestamps();
        });

        Schema::create('seller_tax_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_seller')->nullable()->constrained('sellers');
            $table->string('tax_country', 2);
            $table->string('tax_type', 20);
            $table->string('tax_number', 50);
            $table->string('tax_scheme', 20)->nullable();
            $table->float('reduced_tax_rate', 2)->nullable();
            $table->string('tax_registration_status', 20)->nullable();
            $table->string('invoice_tax_label', 10)->nullable();
            $table->boolean('requires_tax_invoice')->default(false);
            $table->string('qualified_invoice_number', 50)->nullable();
            $table->timestamp('valid_from');
            $table->timestamp('valid_to')->nullable();
            $table->string('validation_status', 20)->nullable();
            $table->timestamp('verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller');
    }
};
