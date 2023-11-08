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

    public function test_sprint_1_1_hr_staff_create_role_listing(): void
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
            'reporting_officer_id' => 1,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1000,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",

        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('jobs.index'));
        $this->assertDatabaseHas('jobs', [
            'id' => 1000,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",


        ]);
        $job = Job::find(1);
        $this->assertEquals($skills, $job->skills->pluck('id')->toArray());
    }

    public function test_sprint_1_2_hr_staff_create_role_listing_without_name_and_description(): void
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
            'is_released' => "true",
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1000,
            'role_name' => '',
            'description' => '',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",

            
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

    public function test_sprint_1_3_hr_staff_create_role_listing_with_used_id(): void
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
            'reporting_officer_id' => 1,
        ]));
        Job::factory()->create([
            'id' => 1000,
            'role_name' => 'Data Analyst',
            'description' => 'Join our dynamic team as a Data Analyst and make an impact by turning data into actionable insights.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",
        ]);
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1000,
            'role_name' => 'Data Analyst',
            'description' => 'Just another dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'id' => 'This ID already exists in the database.',
        ]);
    }

    public function test_sprint_1_4_hr_staff_create_private_role_listing_for_specific_staff(): void
    {
        $user = User::factory()->create([
            'fname' => 'Leroy',
            'lname' => 'Jenkins',
            'dept' => 'IT',
            'email' => 'staff@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::Staff,
            'reporting_officer_id' => 1,
        ]);
        $this->actingAs(User::factory()->create([
            'fname' => 'John',
            'lname' => 'Doe',
            'dept' => 'IT',
            'email' => 'hr@example.com',
            'phone_num' => '97889182',
            'biz_address' => 'this_is_just_some_dummy_data',
            'password' => Hash::make('password'),
            'role' => UserRole::HumanResource,
            'reporting_officer_id' => 1,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1000,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'staff_visibility' => User::where(['fname' => 'Leroy', 'lname' => 'Jenkins'])->pluck('id')->toArray(),
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('job_viewer', [
            'job_id' => 1000,
            'user_id' => $user->id,
        ]);
    }

    public function test_sprint_1_5_hr_staff_create_role_listing_with_past_deadline(): void
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
            'reporting_officer_id' => 1,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1000,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->subDays(1)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",

        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'deadline' => 'The deadline field must be a date after now.',
        ]);
        $this->assertDatabaseMissing('jobs', array_diff_key($data, array_flip(["skills"])));
    }

    public function test_sprint_1_6_hr_staff_create_role_listing_without_name(): void
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
            'reporting_officer_id' => 1,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1000,
            'role_name' => '',
            'description' => 'Here is some dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'role_name' => 'The role name field is required.',
        ]);
        $this->assertDatabaseMissing('jobs', array_diff_key($data, array_flip(["skills"])));
    }

    public function test_sprint_1_7_hr_staff_create_role_listing_without_deadline(): void
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
            'reporting_officer_id' => 1,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1000,
            'role_name' => 'Data Analyst',
            'description' => 'Here is some dummy data.',
            'deadline' => '',
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",
        ];
        $response = $this->post(route('jobs.store'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'deadline' => 'The deadline field is required.',
        ]);
        $this->assertDatabaseMissing('jobs', array_diff_key($data, array_flip(["skills"])));
    }

    public function test_sprint_1_8_hr_staff_create_role_listing_without_description(): void
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
            'reporting_officer_id' => 1,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1000,
            'role_name' => 'Data Analyst',
            'description' => '',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",
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

    public function test_sprint_1_9_hr_staff_create_role_listing_with_default_form_values(): void
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
            'reporting_officer_id' => 1,
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
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",
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

    public function test_5_1_hr_update_role_listing(): void
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
            'reporting_officer_id' => 1,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1000,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",

        ];
        $response = $this->post(route('jobs.update'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('jobs.index'));
        $this->assertDatabaseHas('jobs', [
            'id' => 1000,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",


        ]);
        $job = Job::find(1);
        $this->assertEquals($skills, $job->skills->pluck('id')->toArray());
    
    }
    public function test_5_2_hr_update_role_listing_with_missing_field(): void
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
            'reporting_officer_id' => 1,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1000,
            'role_name' => '',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",

        ];
        $response = $this->post(route('jobs.update'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'role_name' => 'The role name field is required.',
        ]);
        $this->assertDatabaseMissing('jobs', array_diff_key($data, array_flip(["skills"])));
    
    }
    public function test_5_3_hr_update_role_listing_with_deadline_passed(): void
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
            'reporting_officer_id' => 1,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1000,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => '2022-07-25 08:32:25',
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",

        ];
        $response = $this->post(route('jobs.update'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'deadline' => 'The deadline date has already passed.',
        ]);
        
    
    }
    
    public function test_5_4_hr_update_role_listing_with_too_long_title(): void
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
            'reporting_officer_id' => 1,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        $data = [
            'id' => 1000,
            'role_name' => 'Software Engineer Software Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer  Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer Software Engineer',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'skills' => $skills,
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",

        ];
        $response = $this->post(route('jobs.update'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'role_name' => 'The role name field is too long.',
        ]);
       
    
    }
    
    public function test_5_5_hr_update_role_listing_to_an_existing_id(): void
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
            'reporting_officer_id' => 1,
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
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",

        ];
        $response = $this->post(route('jobs.update'), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'id' => 'This ID already exists in the database.',
        ]);
    
    }

    public function test_30_1_hr_submit_application_for_job_listing(): void
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
            'reporting_officer_id' => 1,
        ]));
        $skills = Skill::factory()->count(3)->create()->pluck('id')->toArray();
        
        $response = $this->get(route('profile.edit'));
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('jobs.index'));
        $this->assertDatabaseHas('jobs', [
            'id' => 1000,
            'role_name' => 'Data Analyst',
            'description' => 'This is just some text to be used as dummy data.',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'role_type' => 'Permanent',
            'listing_status' => 'Open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",


        ]);
        $job = Job::find(1);
        $this->assertEquals($skills, $job->skills->pluck('id')->toArray());
    
    }


}
