<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rating;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the rating can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list ratings');
    }

    /**
     * Determine whether the rating can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Rating  $model
     * @return mixed
     */
    public function view(User $user, Rating $model)
    {
        return $user->hasPermissionTo('view ratings');
    }

    /**
     * Determine whether the rating can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create ratings');
    }

    /**
     * Determine whether the rating can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Rating  $model
     * @return mixed
     */
    public function update(User $user, Rating $model)
    {
        return $user->hasPermissionTo('update ratings');
    }

    /**
     * Determine whether the rating can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Rating  $model
     * @return mixed
     */
    public function delete(User $user, Rating $model)
    {
        return $user->hasPermissionTo('delete ratings');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Rating  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete ratings');
    }

    /**
     * Determine whether the rating can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Rating  $model
     * @return mixed
     */
    public function restore(User $user, Rating $model)
    {
        return false;
    }

    /**
     * Determine whether the rating can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Rating  $model
     * @return mixed
     */
    public function forceDelete(User $user, Rating $model)
    {
        return false;
    }
}
