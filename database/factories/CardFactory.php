<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Card as CardModel;
use App\Models\Category;
use Carbon\Carbon;
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
            'id' => fake()->numerify('####'),
            'name' => fake()->name(),
            'slug' => fake()->name(),
            'image' => fake()->url(),
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
            'limit' => doubleval(rand(1, 10000)),
            'annual_fee' => doubleval(rand(1, 10000)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}