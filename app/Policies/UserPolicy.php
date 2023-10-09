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
         return $user->role === UserRole::HumanResource;
     }

     public function update(User $user): bool
     {
         return $user->role === UserRole::HumanResource;
     }

    public function __construct()
    {
        //
    }
}
