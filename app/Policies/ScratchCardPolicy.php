<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ScratchCard;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScratchCardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the scratchCard can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list scratchcards');
    }

    /**
     * Determine whether the scratchCard can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCard  $model
     * @return mixed
     */
    public function view(User $user, ScratchCard $model)
    {
        return $user->hasPermissionTo('view scratchcards');
    }

    /**
     * Determine whether the scratchCard can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create scratchcards');
    }

    /**
     * Determine whether the scratchCard can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCard  $model
     * @return mixed
     */
    public function update(User $user, ScratchCard $model)
    {
        return $user->hasPermissionTo('update scratchcards');
    }

    /**
     * Determine whether the scratchCard can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCard  $model
     * @return mixed
     */
    public function delete(User $user, ScratchCard $model)
    {
        return $user->hasPermissionTo('delete scratchcards');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCard  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete scratchcards');
    }

    /**
     * Determine whether the scratchCard can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCard  $model
     * @return mixed
     */
    public function restore(User $user, ScratchCard $model)
    {
        return false;
    }

    /**
     * Determine whether the scratchCard can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCard  $model
     * @return mixed
     */
    public function forceDelete(User $user, ScratchCard $model)
    {
        return false;
    }
}
