<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */

    public function viewAny(User $user): bool
    {
    //  included managers as well - so they can search for potential candidates
        return in_array($user->role, [UserRole::HumanResource, UserRole::Manager]);
    }

    public function update(User $user): bool
    {
        return $user->role === UserRole::HumanResource;
    }

    public function deleteAccount(User $user): bool
    {
        return in_array($user->role, []);
    }

    public function __construct()
    {
        //
    }
    
    public function notInactive(User $user)
    {
        return in_array($user->role, [UserRole::HumanResource, UserRole::Manager, UserRole::Staff]);
    }
    public function inactive(User $user)
    {
        return in_array($user->role, [UserRole::Inactive]);
    }
    
}
