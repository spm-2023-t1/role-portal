<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Job;
use App\Enums\UserRole;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class Sprint2Test extends TestCase
{
    use RefreshDataBase;

    public function test_sprint2_us6_t1_staff_can_view_role_listing_and_details(): void
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
        $job = Job::factory()->create([
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'Join our dynamic team as a Data Analyst and make an impact by turning data into actionable insights.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
        ]);

        $response = $this->get(route('jobs.show', $job->id));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_sprint2_us7_t2_staff_can_apply_for_job_role(): void
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
        $job = Job::factory()->create([
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'Join our dynamic team as a Data Analyst and make an impact by turning data into actionable insights.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
        ]);
        $data = [
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'remarks' => 'I am interested to join this new team!'
        ];
        $response = $this->patch(route('jobs.apply', $job->id));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_sprint2_us26_t3_hr_staff_can_view_skill_sets_of_other_staff(): void
    {
        // $this->assertTrue(false);
    }

    public function test_sprint2_us30_t4_hr_staff_can_edit_job_application(): void
    {
        // $this->assertTrue(false);
    }

    public function test_sprint2_us30_t5_hr_staff_cannot_apply_for_job_role_with_empty_field(): void
    {
        // $this->assertTrue(false);
    }
}
