<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Skill;
use App\Models\Job;
use App\Enums\UserRole;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class Sprint1Test extends TestCase
{
    use RefreshDatabase;

    public function test_sprint1_us3_t1_hr_staff_can_create_role_listing(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('jobs.index'));
        $this->assertDatabaseHas('jobs', [
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
        ]);
        $job = Job::find(1);
        $this->assertEquals($skills, $job->skills->pluck('id')->toArray());
    }

    public function test_sprint1_us3_t2_hr_staff_cannot_create_role_listing_without_name_and_description(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1,
            'role_name' => '',
            'description' => '',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'role_name' => 'The role name field is required.',
            'description' => 'The description field is required.',
        ]);
        $this->assertDatabaseMissing('jobs', array_diff_key($data, array_flip(["skills"])));
        // TODO: Find out why it is redirecting back to http://localhost instead
        // $response->assertRedirect('route('jobs.create')');
    }

    public function test_sprint1_us3_t3_hr_staff_cannot_create_role_listing_with_used_id(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        Job::factory()->create([
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'Join our dynamic team as a Data Analyst and make an impact by turning data into actionable insights.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ]);
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'Just another dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'id' => 'This ID already exists in the database.',
        ]);
    }

    public function test_sprint1_us3_t4_hr_staff_can_create_private_role_listing_for_specific_staff(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $user = User::factory()->create([
            'fname' => 'Leroy',
            'lname' => 'Jenkins',
            'dept' => 'IT',
            'email' => 'staff@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::Staff,
        ]);
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'staff_visibility' => User::where(['fname' => 'Leroy', 'lname' => 'Jenkins'])->pluck('id')->toArray(),
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('job_viewer', [
            'job_id' => 1,
            'user_id' => $user->id,
        ]);
    }

    public function test_sprint1_us3_t5_hr_staff_cannot_create_role_listing_with_past_deadline(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->subDays(1)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'deadline' => 'The deadline field must be a date after or equal to role listing open.',
        ]);
        $this->assertDatabaseMissing('jobs', array_diff_key($data, array_flip(["skills"])));
    }

    public function test_sprint1_us3_t6_hr_staff_cannot_create_role_listing_without_name(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1,
            'role_name' => '',
            'description' => 'Here is some dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'role_name' => 'The role name field is required.',
        ]);
        $this->assertDatabaseMissing('jobs', array_diff_key($data, array_flip(["skills"])));
    }

    public function test_sprint1_us3_t7_hr_staff_cannot_create_role_listing_without_deadline(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'Here is some dummy data.',
            'deadline' => '',
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'deadline' => 'The deadline field is required.',
        ]);
        $this->assertDatabaseMissing('jobs', array_diff_key($data, array_flip(["skills"])));
    }

    public function test_sprint1_us3_t8_hr_staff_cannot_create_role_listing_without_description(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => '',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'description' => 'The description field is required.',
        ]);
        $this->assertDatabaseMissing('jobs', array_diff_key($data, array_flip(["skills"])));
        // TODO: Find out why it is redirecting back to http://localhost instead
        // $response->assertRedirect('route('jobs.create')');
    }

    public function test_sprint1_us3_t9_hr_staff_cannot_create_role_listing_with_default_form_values(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => null,
            'role_name' => '',
            'description' => '',
            'deadline' => null,
            'skills' => null,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'id' => 'The id field is required.',
            'role_name' => 'The role name field is required.',
            'description' => 'The description field is required.',
            'skills' => 'The skills field is required.',
            'deadline' => 'The deadline field is required.',
        ]);
        $this->assertDatabaseMissing('jobs', array_diff_key($data, array_flip(["skills"])));
    }

    public function test_sprint1_us5_t10_hr_staff_can_update_role_listing(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $job = Job::factory()->create([
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ]);
        $updatedJob = [
            'id' => 1,
            'role_name' => 'Junior Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ];
        $response = $this->patch(route('jobs.update', ['job' => 1]), $updatedJob);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('jobs.index'));
        $this->assertDatabaseHas('jobs', [
            'id' => 1,
            'role_name' => 'Junior Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
        ]);
    }

    public function test_sprint1_us5_t11_hr_staff_cannot_update_role_listing_without_name(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $job = Job::factory()->create([
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ]);
        $data = [
            'id' => 1,
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
        ];
        $response = $this->patch(route('jobs.update', ['job' => 1]), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'role_name' => 'The role name field is required.',
        ]);
    }
    
    public function test_sprint1_us5_t12_hr_staff_cannot_update_role_listing_with_past_deadline(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $job = Job::factory()->create([
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ]);
        $data = [
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->subDays(1)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ];
        $response = $this->patch(route('jobs.update', ['job' => 1]), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'deadline' => 'The deadline field must be a date after or equal to role listing open.',
        ]);
    }

    public function test_sprint1_us5_t13_hr_staff_cannot_update_role_listing_with_invalid_name(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $job = Job::factory()->create([
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ]);
        $data = [
            'id' => 1,
            'role_name' => 'Software Engineer Software Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer  Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ];
        $response = $this->patch(route('jobs.update', ['job' => 1]), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'role_name' => 'The role name field must not be greater than 255 characters.',
        ]);
    }

    public function test_sprint1_us5_t14_hr_staff_cannot_update_role_listing_with_used_id(): void
    {
        $this->actingAs(User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        Job::factory()->create([
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ]);
        $job = Job::factory()->create([
            'id' => 2,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ]);
        $updatedJob = [
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ];
        $response = $this->patch(route('jobs.update', ['job' => 2]), $updatedJob);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'id' => 'The id has already been taken.',
        ]);
        $this->assertDatabaseHas('jobs', [
            'id' => 2,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
        ]);
    }

    public function test_sprint1_us5_t15_hr_staff_can_update_role_listing_with_other_hrs(): void
    {
        $hrOne = User::factory()->create([
            'id' => 1,
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]);
        $hrTwo = User::factory()->create([
            'id' => 2,
            'fname' => 'Jane',
            'lname' => 'Bond',
            'dept' => 'HR',
            'email' => 'hr2@example.com',
            'phone_num' => '94281284',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
        ]);
        $this->actingAs($hrOne);
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $job = Job::factory()->create([
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ]);
        $updatedJob = [
            'id' => 1,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Private',
            'staff_visibility' => [$hrOne, $hrTwo],
            'source_manager_id' => 1,
            'role_listing_open' => now()->addDays(7)->format('Y-m-d'),
            'is_released' => 'true',
        ];
        $response = $this->patch(route('jobs.update', ['job' => 1]), $updatedJob);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('jobs.index'));
        $this->assertDatabaseHas('job_viewer', [
            'job_id' => 1,
            'user_id' => $hrOne->id,
        ]);
        $this->assertDatabaseHas('job_viewer', [
            'job_id' => 1,
            'user_id' => $hrTwo->id,
        ]);
    }
}
