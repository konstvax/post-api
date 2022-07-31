<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class PostFactory
 *
 * @package Database\Factories
 */
class PostFactory extends Factory
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

        $category = Category::inRandomOrder()->first();

        return [
            'title' => $title,
            'content' => $this->faker->realText(150),
            'slug' => $slug,
            'category_id' => $category->id,
        ];
    }
}
