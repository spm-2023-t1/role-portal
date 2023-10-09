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
            'name' => 'Python'
        ]);

        Skill::factory()->create([
            'name' => 'PHP'
        ]);

        Skill::factory()->create([
            'name' => 'Laravel'
        ]);

        Skill::factory()->create([
            'name' => 'HTML5'
        ]);

        Skill::factory()->create([
            'name' => 'CSS3'
        ]);

        Skill::factory()->create([
            'name' => 'User Interview Facilitation'
        ]);

        Skill::factory()->create([
            'name' => 'Web Design'
        ]);

        Skill::factory()->create([
            'name' => 'Artificial Intelligence'
        ]);

        Skill::factory()->create([
            'name' => 'Machine Learning'
        ]);

        Skill::factory()->create([
            'name' => 'Javascript'
        ]);
    }
}
