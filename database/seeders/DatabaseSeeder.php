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
            'fname' => 'Leroy',
            'lname' => 'Jenkins',
            'dept' => 'IT',
            'email' => 'staff@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::Staff,
        ]);

        User::factory()->create([
            'fname' => 'Bret',
            'lname' => 'Stiles',
            'dept' => 'HR',
            'email' => 'hr@example.com',
            'phone_num' => '97827491',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]);

        User::factory()->create([
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'Manager',
            'email' => 'manager@example.com',
            'phone_num' => '99463910',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::Manager,
        ]);

        $this->call(SkillSeeder::class);
        $this->call(UserSkillSeeder::class);

    }
}
