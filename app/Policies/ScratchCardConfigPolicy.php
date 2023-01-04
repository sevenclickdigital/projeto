<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ScratchCardConfig;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScratchCardConfigPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the scratchCardConfig can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list scratchcardconfigs');
    }

    /**
     * Determine whether the scratchCardConfig can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardConfig  $model
     * @return mixed
     */
    public function view(User $user, ScratchCardConfig $model)
    {
        return $user->hasPermissionTo('view scratchcardconfigs');
    }

    /**
     * Determine whether the scratchCardConfig can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create scratchcardconfigs');
    }

    /**
     * Determine whether the scratchCardConfig can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardConfig  $model
     * @return mixed
     */
    public function update(User $user, ScratchCardConfig $model)
    {
        return $user->hasPermissionTo('update scratchcardconfigs');
    }

    /**
     * Determine whether the scratchCardConfig can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardConfig  $model
     * @return mixed
     */
    public function delete(User $user, ScratchCardConfig $model)
    {
        return $user->hasPermissionTo('delete scratchcardconfigs');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardConfig  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete scratchcardconfigs');
    }

    /**
     * Determine whether the scratchCardConfig can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardConfig  $model
     * @return mixed
     */
    public function restore(User $user, ScratchCardConfig $model)
    {
        return false;
    }

    /**
     * Determine whether the scratchCardConfig can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardConfig  $model
     * @return mixed
     */
    public function forceDelete(User $user, ScratchCardConfig $model)
    {
        return false;
    }
}
