<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ScratchCardPlayer;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScratchCardPlayerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the scratchCardPlayer can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list scratchcardplayers');
    }

    /**
     * Determine whether the scratchCardPlayer can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardPlayer  $model
     * @return mixed
     */
    public function view(User $user, ScratchCardPlayer $model)
    {
        return $user->hasPermissionTo('view scratchcardplayers');
    }

    /**
     * Determine whether the scratchCardPlayer can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create scratchcardplayers');
    }

    /**
     * Determine whether the scratchCardPlayer can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardPlayer  $model
     * @return mixed
     */
    public function update(User $user, ScratchCardPlayer $model)
    {
        return $user->hasPermissionTo('update scratchcardplayers');
    }

    /**
     * Determine whether the scratchCardPlayer can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardPlayer  $model
     * @return mixed
     */
    public function delete(User $user, ScratchCardPlayer $model)
    {
        return $user->hasPermissionTo('delete scratchcardplayers');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardPlayer  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete scratchcardplayers');
    }

    /**
     * Determine whether the scratchCardPlayer can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardPlayer  $model
     * @return mixed
     */
    public function restore(User $user, ScratchCardPlayer $model)
    {
        return false;
    }

    /**
     * Determine whether the scratchCardPlayer can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardPlayer  $model
     * @return mixed
     */
    public function forceDelete(User $user, ScratchCardPlayer $model)
    {
        return false;
    }
}
