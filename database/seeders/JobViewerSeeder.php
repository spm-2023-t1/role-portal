<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobViewerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('job_viewer')->insert([
            'id' => 1,
            'job_id' => 4,
            'user_id' => 9,
        ]);
        DB::table('job_viewer')->insert([
            'id' => 2,
            'job_id' => 5,
            'user_id' => 6,
        ]);
        DB::table('job_viewer')->insert([
            'id' => 3,
            'job_id' => 5,
            'user_id' => 2,
        ]);
    }
}
