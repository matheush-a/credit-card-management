<?php

namespace Database\Factories;

use App\Models\Card as CardModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    protected $model = CardModel::class;

    public function definition()
    {
        return [
            'id' => fake()->numerify('#'),
            'name' => fake()->name(),
            'slug' => fake()->name(),
            'image' => fake()->url(),
            'brand_id' => fake()->numerify('#'),
            'category_id' => fake()->numerify('#'),
            'limit' => fake()->numerify('####'),
            'annual_fee' => fake()->numerify('####'),
        ];
    }
}