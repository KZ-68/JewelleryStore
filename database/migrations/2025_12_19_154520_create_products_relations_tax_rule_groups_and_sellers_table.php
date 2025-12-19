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
            $table->foreignId('id_tax_rule_group')->nullable()->constrained('tax_rule_groups');
            $table->foreignId('id_seller')->nullable()->constrained('sellers');
        });
    }

};
