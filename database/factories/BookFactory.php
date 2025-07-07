<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [

            'author_id' => rand(1,5),
            'category_id' => rand(1,5),
            'title' => $this->faker->sentence,
            'publisher' => $this->faker->name,
            'published_date' => $this->faker->date,
            'description' => $this->faker->paragraph,
            'photo' => "JaneEyre.jpg",
            'file' => "Jane Eyre.pdf",
            'temp_delete' => 0,
            'download_count' => 0,
        ];
    }
}
