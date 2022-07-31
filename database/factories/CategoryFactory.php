<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class CategoryFactory
 *
 * @package Database\Factories
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();

        $slug = $this->faker->boolean(30) ? $this->faker->unique()->slug : \Str::slug($title);

        return [
            'title' => $title,
            'content' => $this->faker->realText(150),
            'slug' => $slug,
        ];
    }

}
