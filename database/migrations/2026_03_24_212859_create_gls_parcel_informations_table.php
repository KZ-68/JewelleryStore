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
        Schema::create('gls_parcel_informations', function (Blueprint $table) {
            $table->id();
            $table->string('parcel_id', 11);
            $table->string('reference', 11);
            $table->string('postal_code', 8);
            $table->string('parcel_status', 13);
            $table->string('description', 25);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gls_parcel_informations');
    }
};
