<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BranchHour;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchHourPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the branchHour can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list branchhours');
    }

    /**
     * Determine whether the branchHour can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BranchHour  $model
     * @return mixed
     */
    public function view(User $user, BranchHour $model)
    {
        return $user->hasPermissionTo('view branchhours');
    }

    /**
     * Determine whether the branchHour can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create branchhours');
    }

    /**
     * Determine whether the branchHour can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BranchHour  $model
     * @return mixed
     */
    public function update(User $user, BranchHour $model)
    {
        return $user->hasPermissionTo('update branchhours');
    }

    /**
     * Determine whether the branchHour can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BranchHour  $model
     * @return mixed
     */
    public function delete(User $user, BranchHour $model)
    {
        return $user->hasPermissionTo('delete branchhours');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BranchHour  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete branchhours');
    }

    /**
     * Determine whether the branchHour can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BranchHour  $model
     * @return mixed
     */
    public function restore(User $user, BranchHour $model)
    {
        return false;
    }

    /**
     * Determine whether the branchHour can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BranchHour  $model
     * @return mixed
     */
    public function forceDelete(User $user, BranchHour $model)
    {
        return false;
    }
}
