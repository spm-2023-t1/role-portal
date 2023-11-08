<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Job;
use App\Models\Skill;
use App\Enums\UserRole;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class Sprint3Test extends TestCase
{
    use RefreshDataBase;

    public function test_sprint3_us8_t1_hr_can_filter_role_listing_by_skills(): void
    {
        $this->actingAs(User::factory()->create([
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::Staff,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $job = Job::factory()->create([
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'Join our dynamic team as a Data Analyst and make an impact by turning data into actionable insights.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
        ]);
        foreach ($skills as $skill) {
            $skill = Skill::find($skill);
            if ($skill != null) {
                $job->skills()->attach($skill);
            }
        }
        $response = $this->get(route('jobs.index', ['filter_skill' => $skills]));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_sprint3_us8_t2_hr_cannot_filter_candidates_without_filter(): void
    {
        $this->actingAs(User::factory()->create([
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $response = $this->get(route('users.index', ['search' => 'test']))->assertSee('No staff found.');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_sprint3_us108_t3_hr_staff_can_view_skill_sets_of_job_applicants(): void
    {
        
    }

    public function test_sprint3_us32_t4_staff_can_view_their_own_skill_sets(): void
    {

    }
}
