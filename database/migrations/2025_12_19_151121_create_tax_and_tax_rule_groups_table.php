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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->float('percentage', 2);
            $table->boolean('applicable')->default(true);
            $table->string('type', 20);
            $table->string('description', 128);
            $table->timestamps();
        });

        Schema::create('tax_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tax')->nullable()->constrained('taxes');
            $table->foreignId('id_country')->nullable()->constrained('countries');
            $table->string('behavior', 20);
            $table->integer('rate_order');
        });

        Schema::create('tax_rule_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tax_rule')->nullable()->constrained('tax_rules');
            $table->string('name', 255);
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_rule_groups');
    }
};
