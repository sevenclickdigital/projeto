<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Holiday;
use Illuminate\Auth\Access\HandlesAuthorization;

class HolidayPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the holiday can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list holidays');
    }

    /**
     * Determine whether the holiday can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Holiday  $model
     * @return mixed
     */
    public function view(User $user, Holiday $model)
    {
        return $user->hasPermissionTo('view holidays');
    }

    /**
     * Determine whether the holiday can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create holidays');
    }

    /**
     * Determine whether the holiday can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Holiday  $model
     * @return mixed
     */
    public function update(User $user, Holiday $model)
    {
        return $user->hasPermissionTo('update holidays');
    }

    /**
     * Determine whether the holiday can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Holiday  $model
     * @return mixed
     */
    public function delete(User $user, Holiday $model)
    {
        return $user->hasPermissionTo('delete holidays');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Holiday  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete holidays');
    }

    /**
     * Determine whether the holiday can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Holiday  $model
     * @return mixed
     */
    public function restore(User $user, Holiday $model)
    {
        return false;
    }

    /**
     * Determine whether the holiday can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Holiday  $model
     * @return mixed
     */
    public function forceDelete(User $user, Holiday $model)
    {
        return false;
    }
}
