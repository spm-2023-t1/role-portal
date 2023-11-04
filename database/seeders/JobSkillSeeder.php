<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('job_skill')->insert([
            'id' => 1,
            'job_id' => 1,
            'skill_id' => 5,
        ]);
        DB::table('job_skill')->insert([
            'id' => 2,
            'job_id' => 1,
            'skill_id' => 4,
        ]);
        DB::table('job_skill')->insert([
            'id' => 3,
            'job_id' => 2,
            'skill_id' => 11,
        ]);
        DB::table('job_skill')->insert([
            'id' => 4,
            'job_id' => 7,
            'skill_id' => 14,
        ]);
        DB::table('job_skill')->insert([
            'id' => 5,
            'job_id' => 7,
            'skill_id' => 10,
        ]);
        DB::table('job_skill')->insert([
            'id' => 6,
            'job_id' => 7,
            'skill_id' => 7,
        ]);
        DB::table('job_skill')->insert([
            'id' => 7,
            'job_id' => 5,
            'skill_id' => 10,
        ]);
        DB::table('job_skill')->insert([
            'id' => 8,
            'job_id' => 5,
            'skill_id' => 1,
        ]);
        DB::table('job_skill')->insert([
            'id' => 9,
            'job_id' => 8,
            'skill_id' => 1,
        ]);
        DB::table('job_skill')->insert([
            'id' => 10,
            'job_id' => 10,
            'skill_id' => 10,
        ]);
        DB::table('job_skill')->insert([
            'id' => 11,
            'job_id' => 10,
            'skill_id' => 2,
        ]);
        DB::table('job_skill')->insert([
            'id' => 12,
            'job_id' => 10,
            'skill_id' => 1,
        ]);
        DB::table('job_skill')->insert([
            'id' => 13,
            'job_id' => 4,
            'skill_id' => 8,
        ]);
        DB::table('job_skill')->insert([
            'id' => 14,
            'job_id' => 4,
            'skill_id' => 1,
        ]);
        DB::table('job_skill')->insert([
            'id' => 15,
            'job_id' => 6,
            'skill_id' => 8,
        ]);
        DB::table('job_skill')->insert([
            'id' => 16,
            'job_id' => 6,
            'skill_id' => 5,
        ]);
        DB::table('job_skill')->insert([
            'id' => 17,
            'job_id' => 6,
            'skill_id' => 1,
        ]);
        DB::table('job_skill')->insert([
            'id' => 18,
            'job_id' => 3,
            'skill_id' => 5,
        ]);
        DB::table('job_skill')->insert([
            'id' => 19,
            'job_id' => 3,
            'skill_id' => 2,
        ]);
        DB::table('job_skill')->insert([
            'id' => 20,
            'job_id' => 9,
            'skill_id' => 8,
        ]);
        DB::table('job_skill')->insert([
            'id' => 21,
            'job_id' => 9,
            'skill_id' => 1,
        ]);
        DB::table('job_skill')->insert([
            'id' => 22,
            'job_id' => 9,
            'skill_id' => 9,
        ]);
    }
}
