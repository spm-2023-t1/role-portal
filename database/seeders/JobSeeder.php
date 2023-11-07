<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Job::factory()->create([
            'id' => '1',
            'role_name' => 'IT Support Specialist',
            'description' => 'As an IT Support Specialist, you will be a key player in resolving IT-related issues and providing expert guidance to our clients.',
            'role_type' => 'permanent',
            'listing_status' => 'open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'deadline' => '2024-02-22 15:00:00',
            'role_listing_open' => '2023-11-04 15:20:52',
            'source_manager_id' => '12',
            'created_at' => '2023-11-04 15:19:52',
            'updated_at' => '2023-11-04 15:19:52',
            'is_released' => "true",
        ]);
        Job::factory()->create([
            'id' => '2',
            'role_name' => 'Graphic Designer',
            'description' => ' Graphic Designer to produce visually compelling designs and artwork for our marketing materials, websites, and branding initiatives.',
            'role_type' => 'temporary',
            'listing_status' => 'open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'deadline' => '2024-01-29 15:00:00',
            'role_listing_open' => '2023-10-23 09:21:23',
            'source_manager_id' => '12',
            'created_at' => '2023-10-23 09:21:23',
            'updated_at' => '2023-10-23 17:30:03',
            'is_released' => "true",
        ]);
        Job::factory()->create([
            'id' => '3',
            'role_name' => 'Network Administrator',
            'description' => "Network Administrator is responsible for designing, implementing, and maintaining an organization's computer networks, ensuring optimal performance, security, and connectivity.",
            'role_type' => 'permanent',
            'listing_status' => 'closed',
            'owner_id' => '7',
            'update_user_id' => '7',
            'deadline' => '2024-01-17 15:00:00',
            'role_listing_open' => '2023-09-21 12:43:25',
            'source_manager_id' => '12',
            'created_at' => '2023-09-21 12:43:25',
            'updated_at' => '2023-09-21 12:43:25',
            'is_released' => "true",
        ]);
        Job::factory()->create([
            'id' => '4',
            'role_name' => 'Data Analyst',
            'description' => "Data Analyst gathers, analyzes, and interprets data to provide valuable insights and support data-driven decision-making within the organization.",
            'role_type' => 'permanent',
            'listing_status' => 'private',
            'owner_id' => '7',
            'update_user_id' => '7',
            'deadline' => '2024-01-21 15:00:00',
            'role_listing_open' => '2023-08-25 16:42:11',
            'source_manager_id' => '12',
            'created_at' => '2023-08-25 16:42:11',
            'updated_at' => '2023-08-25 16:42:11',
            'is_released' => "true",
        ]);
        Job::factory()->create([
            'id' => '5',
            'role_name' => 'Software Developer',
            'description' => "Software Developer designs, codes, tests, and maintains software applications, ensuring they meet the organization's needs and quality standards.",
            'role_type' => 'temporary',
            'listing_status' => 'private',
            'owner_id' => '7',
            'update_user_id' => '7',
            'deadline' => '2024-03-14 15:00:00',
            'role_listing_open' => '2023-07-25 08:32:25',
            'source_manager_id' => '12',
            'created_at' => '2023-07-25 08:32:25',
            'updated_at' => '2023-07-25 08:32:25',
            'is_released' => "true",
        ]);
        Job::factory()->create([
            'id' => '6',
            'role_name' => 'Cybersecurity Analyst',
            'description' => " Cybersecurity Analyst is responsible for monitoring, identifying, and mitigating security threats and vulnerabilities to protect the organization's digital assets and data.",
            'role_type' => 'permanent',
            'listing_status' => 'open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'deadline' => '2024-01-21 15:00:00',
            'role_listing_open' => '2023-08-25 16:42:11',
            'source_manager_id' => '12',
            'created_at' => '2023-08-25 16:42:11',
            'updated_at' => '2023-08-25 16:42:11',
            'is_released' => "true",
        ]);
        Job::factory()->create([
            'id' => '7',
            'role_name' => 'Web Developer',
            'description' => "Web Developer designs and implements web applications and sites, creating engaging user experiences and ensuring optimal functionality.",
            'role_type' => 'temporary',
            'listing_status' => 'closed',
            'owner_id' => '7',
            'update_user_id' => '7',
            'deadline' => '2024-02-19 15:00:00',
            'role_listing_open' => '2023-10-24 12:24:01',
            'source_manager_id' => '12',
            'created_at' => '2023-10-24 12:24:01',
            'updated_at' => '2023-10-24 12:24:01',
            'is_released' => "true",
        ]);
        Job::factory()->create([
            'id' => '8',
            'role_name' => 'Business Analyst',
            'description' => "Business Analyst acts as a bridge between the IT department and business units, analyzing processes and recommending technology solutions to enhance efficiency and meet business objectives.",
            'role_type' => 'permanent',
            'listing_status' => 'open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'deadline' => '2024-02-11 15:00:00',
            'role_listing_open' => '2023-10-19 08:51:37',
            'source_manager_id' => '12',
            'created_at' => '2023-10-19 08:51:37',
            'updated_at' => '2023-10-19 16:20:49',
            'is_released' => "true",
        ]);
        Job::factory()->create([
            'id' => '9',
            'role_name' => 'Machine Learning Engineer',
            'description' => "Machine Learning Engineer specializes in developing and implementing machine learning algorithms and models to improve business processes and decision-making through data-driven insights.",
            'role_type' => 'temporary',
            'listing_status' => 'open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'deadline' => '2024-01-15 15:00:00',
            'role_listing_open' => '2023-11-01 09:45:13',
            'source_manager_id' => '12',
            'created_at' => '2023-11-01 09:45:13',
            'updated_at' => '2023-11-01 09:45:13',
            'is_released' => "true",
        ]);
        Job::factory()->create([
            'id' => '10',
            'role_name' => 'Quality Assurance (QA) Analyst',
            'description' => "Quality Assurance (QA) Analyst is responsible for testing and ensuring the quality of software and applications, identifying issues, and ensuring they meet the required standards and functionality.",
            'role_type' => 'permanent',
            'listing_status' => 'open',
            'owner_id' => '7',
            'update_user_id' => '7',
            'deadline' => '2024-02-10 15:00:00',
            'role_listing_open' => '2023-11-02 12:41:30',
            'source_manager_id' => '12',
            'created_at' => '2023-11-02 12:41:30',
            'updated_at' => '2023-11-02 12:41:30',
            'is_released' => "true",
        ]);
    }
}
