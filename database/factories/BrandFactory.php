<?php

namespace Database\Factories;

use App\Models\Brand as BrandModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    protected $model = BrandModel::class;

    public function definition()
    {
        return [
            'id' => fake()->numerify('####'),
            'name' => fake()->name(),
        ];
    }
}
