<?php

namespace App\Policies\V1;

use App\Models\User;
use App\Permissions\V1\Abilities;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan(Abilities::CreateUser);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->tokenCan(Abilities::UpdateUser);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->tokenCan(Abilities::DeleteUser);
    }

    /**
     * Determine whether the user can create models.
     */
    public function createAuthor(User $user): bool
    {
        return $user->tokenCan(Abilities::CreateUser);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateAuthor(User $user, User $model): bool
    {
        return $user->tokenCan(Abilities::UpdateUser);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteAuthor(User $user, User $model): bool
    {
        return $user->tokenCan(Abilities::DeleteUser);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }
}
