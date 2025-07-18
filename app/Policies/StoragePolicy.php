<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Storage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StoragePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Storage $storage): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {

        if (auth()->user()->role === Role::Admin) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Storage $storage): bool
    {

        if (auth()->user()->role === Role::Admin) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Storage $storage): bool
    {

        if (auth()->user()->role === Role::Admin) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Storage $storage): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Storage $storage): bool
    {
        return false;
    }
}
