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
            $table->string('slug')->unique();
            $table->decimal('rate', 2, 2);
            $table->boolean('applicable')->default(true);
            $table->string('type', 20);
            $table->string('description', 128)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('tax_rule_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->boolean('active')->default(true);
        });

        Schema::create('tax_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_id')->nullable()->constrained('taxes');
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('tax_rule_group_id')->nullable()->constrained('tax_rule_groups');
            $table->string('behavior', 20);
            $table->integer('rate_order');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxes');
        Schema::dropIfExists('tax_rule_groups');
        Schema::dropIfExists('tax_rules');
    }
};
