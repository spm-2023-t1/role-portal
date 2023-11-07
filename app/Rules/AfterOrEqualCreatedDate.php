<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Job;
use Carbon\Carbon;

// class AfterOrEqualCreatedDate implements Rule
// {
//     protected $job;

//     public function __construct(Job $job)
//     {
//         $this->job = $job;
//     }

//     public function passes($attribute, $value)
//     {
//         // $job = Job::find($this->jobId);

//         // if ($job) {
//         //     $createdDate = new Carbon($job->created_at);
//         //     $selectedDate = new Carbon($value);

//         //     return $selectedDate->greaterThanOrEqualTo($createdDate);
//         // }

//         // return false;

//         $createdDate = new Carbon($this->job->created_at);
//         $selectedDate = new Carbon($value);

//         return $selectedDate->greaterThanOrEqualTo($createdDate);
//     }

//     public function message()
//     {
//         return 'The :attribute must be a date after or equal to the job\'s creation date.';
//     }
// }

class AfterOrEqualCreatedDate implements Rule
{
    protected $jobId;

    public function __construct($jobId)
    {
        $this->jobId = $jobId;
    }

    public function passes($attribute, $value)
    {
        $job = Job::find($this->jobId);

        if ($job) {
            $createdDate = new Carbon($job->created_at);
            $selectedDate = new Carbon($value);

            // dd($selectedDate, $createdDate);

            return $selectedDate->greaterThanOrEqualTo($createdDate);
        }

        return false;
    }

    public function message()
    {
        return 'The :attribute must be a date after or equal to the job\'s creation date.';
    }
}

