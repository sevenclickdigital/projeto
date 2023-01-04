<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the branch can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list branches');
    }

    /**
     * Determine whether the branch can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Branch  $model
     * @return mixed
     */
    public function view(User $user, Branch $model)
    {
        return $user->hasPermissionTo('view branches');
    }

    /**
     * Determine whether the branch can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create branches');
    }

    /**
     * Determine whether the branch can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Branch  $model
     * @return mixed
     */
    public function update(User $user, Branch $model)
    {
        return $user->hasPermissionTo('update branches');
    }

    /**
     * Determine whether the branch can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Branch  $model
     * @return mixed
     */
    public function delete(User $user, Branch $model)
    {
        return $user->hasPermissionTo('delete branches');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Branch  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete branches');
    }

    /**
     * Determine whether the branch can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Branch  $model
     * @return mixed
     */
    public function restore(User $user, Branch $model)
    {
        return false;
    }

    /**
     * Determine whether the branch can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Branch  $model
     * @return mixed
     */
    public function forceDelete(User $user, Branch $model)
    {
        return false;
    }
}
