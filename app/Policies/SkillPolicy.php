<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SkillPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     return $user->role === UserRole::HumanResource;
    // }

    public function viewAny(User $user): bool
{
    return in_array($user->role, [UserRole::HumanResource, UserRole::Manager]);
}

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Skill $skill): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // return $user->role === UserRole::HumanResource;
        return in_array($user->role, [UserRole::HumanResource, UserRole::Manager]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Skill $skill): bool
    {
        return in_array($user->role, [UserRole::HumanResource, UserRole::Manager]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Skill $skill): bool
    {
        return $user->role === UserRole::HumanResource;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Skill $skill): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Skill $skill): bool
    {
        //
    }
}
