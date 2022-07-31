<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        if (!Category::all()->count()) {
            for ($i = 1; $i < 40; $i++) {
                $parents = Category::inRandomOrder()
                    ->whereNull('parent_id')
                    ->get()
                    ->mapWithKeys(function ($model) {
                        return ['id' => $model->id];
                    })
                    ->toArray();

                $result = rand(1, 3) === 1 && !empty($parents) ? $parents[array_rand($parents)] : null;

                Category::factory()->create([
                    'parent_id' => $result
                ]);
            }

            Post::factory(100)->create();
        }
    }
}
