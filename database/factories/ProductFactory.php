<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\product;
use App\Models\User;
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
    protected $model = Product::class;

     public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'code' => $this->faker->unique()->randomNumber(5),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'image_url' => $this->faker->imageUrl(),
            'description' => $this->faker->paragraph,
            'tags' => $this->faker->words(3, true),
        ];
    }
}
