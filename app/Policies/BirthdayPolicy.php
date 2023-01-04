<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Birthday;
use Illuminate\Auth\Access\HandlesAuthorization;

class BirthdayPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the birthday can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list birthdays');
    }

    /**
     * Determine whether the birthday can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Birthday  $model
     * @return mixed
     */
    public function view(User $user, Birthday $model)
    {
        return $user->hasPermissionTo('view birthdays');
    }

    /**
     * Determine whether the birthday can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create birthdays');
    }

    /**
     * Determine whether the birthday can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Birthday  $model
     * @return mixed
     */
    public function update(User $user, Birthday $model)
    {
        return $user->hasPermissionTo('update birthdays');
    }

    /**
     * Determine whether the birthday can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Birthday  $model
     * @return mixed
     */
    public function delete(User $user, Birthday $model)
    {
        return $user->hasPermissionTo('delete birthdays');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Birthday  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete birthdays');
    }

    /**
     * Determine whether the birthday can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Birthday  $model
     * @return mixed
     */
    public function restore(User $user, Birthday $model)
    {
        return false;
    }

    /**
     * Determine whether the birthday can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Birthday  $model
     * @return mixed
     */
    public function forceDelete(User $user, Birthday $model)
    {
        return false;
    }
}
