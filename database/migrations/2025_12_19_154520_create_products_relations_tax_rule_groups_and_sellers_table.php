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
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('products');

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_rule_group_id')->nullable()->constrained('tax_rule_groups');
            $table->foreignId('seller_id')->nullable()->constrained('sellers');
            $table->string('name', 255);
            $table->string('slug')->unique();
            $table->string('description', 255)->nullable();
            $table->string('reference', 100);
            $table->string('ean13', 13)->nullable();
            $table->integer('quantity');
            $table->decimal('price_ht', 20, 6);
            $table->decimal('retail_price', 20, 6);
            $table->decimal('cost_price', 20, 6);
            $table->string('product_condition', 20)->nullable();
            $table->string('short_description', 100)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('category_id')->references('id')->on('categories');
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
