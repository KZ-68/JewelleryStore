<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use SoftDeletes;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug')->unique();
            $table->string('description', 255)->nullable();
            $table->string('reference', 100);
            $table->string('ean13', 13)->nullable();
            $table->integer('quantity');
            $table->float('price_ht', 2);
            $table->float('cost_price', 2);
            $table->string('product_condition', 20)->nullable();
            $table->string('short_description', 100)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->boolean('active');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
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
