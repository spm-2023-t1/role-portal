<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory()->create([
             'name' => 'Test Staff',
             'email' => 'staff@example.com',
             'password' => Hash::make('password'),
             'role' => UserRole::Staff,
         ]);

        User::factory()->create([
            'name' => 'Test HR',
            'email' => 'hr@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]);

        $this->call(SkillSeeder::class);
    }
}
