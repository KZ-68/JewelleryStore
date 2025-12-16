<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'reference' => Str::random(7),
            'ean13' => fake()->isbn13(),
            'retailPrice' => fake()->randomFloat(6, 1),
        ];
    }

    /**
     * Indicate this product need to be activated
    */
    public function activated(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'active' => 1,
        ]);
    }

    /**
     * Indicate this product need to be deactivated
    */
    public function deactivated(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'active' => 0,
        ]);
    }
}
