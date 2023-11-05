<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // decided to create 10 legit skills so it looks better for the demo - original code: `Skill::factory()->count(10)->create();`
        Skill::factory()->create([
            'name' => 'Python',
            'created_by' => '7',
            'updated_by' => '7'
        ]);

        Skill::factory()->create([
            'name' => 'PHP',
            'created_by' => '7',
            'updated_by' => '7'
        ]);

        Skill::factory()->create([
            'name' => 'Laravel',
            'created_by' => '7',
            'updated_by' => '7'
        ]);

        Skill::factory()->create([
            'name' => 'HTML5',
            'created_by' => '7',
            'updated_by' => '7'
        ]);

        Skill::factory()->create([
            'name' => 'CSS3',
            'created_by' => '7',
            'updated_by' => '7'
        ]);

        Skill::factory()->create([
            'name' => 'User Interview Facilitation',
            'created_by' => '7',
            'updated_by' => '7'
        ]);

        Skill::factory()->create([
            'name' => 'Web Design',
            'created_by' => '7',
            'updated_by' => '7'
        ]);

        Skill::factory()->create([
            'name' => 'Artificial Intelligence',
            'created_by' => '7',
            'updated_by' => '7'
        ]);

        Skill::factory()->create([
            'name' => 'Machine Learning',
            'created_by' => '7',
            'updated_by' => '7'
        ]);

        Skill::factory()->create([
            'name' => 'Javascript',
            'created_by' => '7',
            'updated_by' => '7'
        ]);
        Skill::factory()->create([
            'name' => 'Photoshop',
            'created_by' => '7',
            'updated_by' => '7'
        ]);
        Skill::factory()->create([
            'name' => 'SQL',
            'created_by' => '7',
            'updated_by' => '7'
        ]);
    }
}
