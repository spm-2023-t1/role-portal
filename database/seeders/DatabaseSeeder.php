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
            'fname' => 'Harry',
            'lname' => 'Potter',
            'dept' => 'IT',
            'email' => 'pharry@staff.com',
            'phone_num' => '93481923',
            'biz_address' => '63 East Coast Road #05-01',
            'password' => Hash::make('password'),
            'role' => UserRole::Inactive,
        ]);

        User::factory()->create([
            'fname' => 'Jack',
            'lname' => 'Green',
            'dept' => 'Manager',
            'email' => 'gjack@manager.com',
            'phone_num' => '95114536',
            'biz_address' => '134 Smith St #03-61',
            'password' => Hash::make('password'),
            'role' => UserRole::Inactive,
        ]);

        User::factory()->create([
            'fname' => 'Leroy',
            'lname' => 'Jenkins',
            'dept' => 'IT',
            'email' => 'jleroy@staff.com',
            'phone_num' => '97889182',
            'biz_address' => '3 Temasek Boulevard, #01-035/03',
            'password' => Hash::make('password'),
            'role' => UserRole::Staff,
            'current_role' => 10,
        ]);
        
        User::factory()->create([
            'fname' => 'Dante',
            'lname' => 'Sherman',
            'dept' => 'Multimedia',
            'email' => 'sdante@staff.com',
            'phone_num' => '92572930',
            'biz_address' => '352 Ang Mo Kio St 32 #13-125',
            'password' => Hash::make('password'),
            'role' => UserRole::Staff,
            'current_role' => 3,
        ]);

        User::factory()->create([
            'fname' => 'Adam',
            'lname' => 'Obrien',
            'dept' => 'R&D',
            'email' => 'oadam@staff.com',
            'phone_num' => '96586302',
            'biz_address' => '154 West Coast Road #02-03',
            'password' => Hash::make('password'),
            'role' => UserRole::Staff,
            'current_role' => 1,
        ]);
        
        User::factory()->create([
            'fname' => 'Todd',
            'lname' => 'Ramsay',
            'dept' => 'IT',
            'email' => 'rtodd@staff.com',
            'phone_num' => '97352799',
            'biz_address' => '101 Cecil Street #10-083',
            'password' => Hash::make('password'),
            'role' => UserRole::Staff,
            'current_role' => 4,
        ]);


        User::factory()->create([
            'fname' => 'Levi',
            'lname' => 'Baker',
            'dept' => 'IT',
            'email' => 'blevi@staff.com',
            'phone_num' => '92572930',
            'biz_address' => 'Frankel Estate 685A East Coast Road',
            'password' => Hash::make('password'),
            'role' => UserRole::Staff,
            'current_role' => 7,
        ]);

        User::factory()->create([
            'fname' => 'Bret',
            'lname' => 'Stiles',
            'dept' => 'HR',
            'email' => 'sbret@hr.com',
            'phone_num' => '97827491',
            'biz_address' => '750A Chai Chee Road #07-02 Technopark',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]);

        User::factory()->create([
            'fname' => 'Ahmad',
            'lname' => 'Green',
            'dept' => 'HR',
            'email' => 'gahmad@hr.com',
            'phone_num' => '95114787',
            'biz_address' => '130 Tanjong Rhu Road #01-01',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]);

        User::factory()->create([
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'Manager',
            'email' => 'DJohn@manager.com',
            'phone_num' => '99483910',
            'biz_address' => '5 Purvis St #01-01',
            'password' => Hash::make('password'),
            'role' => UserRole::Manager,
        ]);

        User::factory()->create([
            'fname' => 'Warren',
            'lname' => 'Moyer',
            'dept' => 'Manager',
            'email' => 'mwarren@manager.com',
            'phone_num' => '96375515',
            'biz_address' => '335 Smith St #02-203',
            'password' => Hash::make('password'),
            'role' => UserRole::Manager,
        ]);

        User::factory()->create([
            'fname' => 'Nathan',
            'lname' => 'Summers',
            'dept' => 'Manager',
            'email' => 'snathan@manager.com',
            'phone_num' => '94201033',
            'biz_address' => '3791 Jalan Bukit Merah #10-19',
            'password' => Hash::make('password'),
            'role' => UserRole::Manager,
        ]);

        User::factory()->create([
            'fname' => 'Elaine',
            'lname' => 'Mcdowell',
            'dept' => 'Manager',
            'email' => 'melaine@manager.com',
            'phone_num' => '92817277',
            'biz_address' => '62 Toh Guan Road 01-00',
            'password' => Hash::make('password'),
            'role' => UserRole::Manager,
        ]);

        $this->call(JobSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(JobSkillSeeder::class);
        $this->call(JobViewerSeeder::class);
        $this->call(UserSkillSeeder::class);

    }
}
