<?php

namespace Database\Factories;

use App\Models\Category as CategoryModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = CategoryModel::class;

    public function definition()
    {
        return [
            'id' => fake()->numerify('####'),
            'name' => fake()->name(),
        ];
    }
}
