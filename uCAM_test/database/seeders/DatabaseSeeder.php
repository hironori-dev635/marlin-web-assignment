<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::factory(50)->create();
        Post::factory(10)->create();
        Document::factory(10)->create();
    }
}
