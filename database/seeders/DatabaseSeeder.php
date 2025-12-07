<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Create a couple of test users using factory
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Deterministic admin user for local/demo environments.
        // Uses firstOrCreate so running seeds multiple times is safe.
        User::firstOrCreate(
            ['email' => 'admin@demo.test'],
            [
                'name' => 'Administrator',
                // The User model casts 'password' => 'hashed', so plain text here will be hashed.
                'password' => '1234',
            ]
        );
    }
}
