<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Author;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         Book::factory()->count(25)->create();
         User::factory()->count(15)->create();
         Author::factory()->count(10)->create();

        $list = ['Romance', 'Novel', 'Funny', 'Newspaper', 'Magazines'];
        foreach ($list as $name) {
            \App\Models\Category::create(['name' => $name]);
        }

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
