<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Job $job): bool
    {
        //
    }

    public function viewPrivate(Job $job, User $user): bool
    {
        return $job->viewers->contains($user);
    }

    public function viewJobs(User $user, Job $job)
    {
        
        // HR users can view all jobs
        if($user->isHR()) {
            // dd($user);
            return true;
        }

        // Staff users can only view jobs that are is_released == true and they are viewers of that job
        if($user->isStaff()) {
            // if($job->listing_status == 'open' || $job->listing_status == 'closed') {
            if ($job->is_released == "true" and $job->listing_status != 'private') {
                return true;
            }

            elseif($job->listing_status == 'private' and $job->is_released == "true") {
                foreach($job->viewers as $viewer) {
                    if($viewer->id == $user->id) {
                        return true;
                    }
                }
            }
        }

        // Managers can only view jobs that are is_released == true, they are viewers of that job or if they are the source_manager of that job
        if($user->isManager()) {

            if ($job->is_released == "true" and $job->listing_status != 'private') {
                return true;
            }

            if($job->listing_status == 'private' and $job->is_released == "true") {
                foreach($job->viewers as $viewer) {
                    if($viewer->id == $user->id) {
                        return true;
                    }
                }
            }

            if($job->source_manager_id == $user->id) {
                return true;
            }
        }
    }
    
    
    public function viewApplicationHR(User $user): bool
    {
        return in_array($user->role, [UserRole::HumanResource]);
    }

    public function viewApplicationManager(User $user): bool
    {
        return in_array($user->role, [UserRole::Manager]);
    }

    public function viewRoleListingOpen(User $user): bool
    {
        return in_array($user->role, [UserRole::HumanResource]);
    }



    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::HumanResource;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->role === UserRole::HumanResource;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Job $job): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Job $job): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Job $job): bool
    {
        //
    }
}
