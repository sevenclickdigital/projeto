<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ScratchCardAnswer;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScratchCardAnswerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the scratchCardAnswer can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list scratchcardanswers');
    }

    /**
     * Determine whether the scratchCardAnswer can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardAnswer  $model
     * @return mixed
     */
    public function view(User $user, ScratchCardAnswer $model)
    {
        return $user->hasPermissionTo('view scratchcardanswers');
    }

    /**
     * Determine whether the scratchCardAnswer can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create scratchcardanswers');
    }

    /**
     * Determine whether the scratchCardAnswer can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardAnswer  $model
     * @return mixed
     */
    public function update(User $user, ScratchCardAnswer $model)
    {
        return $user->hasPermissionTo('update scratchcardanswers');
    }

    /**
     * Determine whether the scratchCardAnswer can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardAnswer  $model
     * @return mixed
     */
    public function delete(User $user, ScratchCardAnswer $model)
    {
        return $user->hasPermissionTo('delete scratchcardanswers');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardAnswer  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete scratchcardanswers');
    }

    /**
     * Determine whether the scratchCardAnswer can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardAnswer  $model
     * @return mixed
     */
    public function restore(User $user, ScratchCardAnswer $model)
    {
        return false;
    }

    /**
     * Determine whether the scratchCardAnswer can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ScratchCardAnswer  $model
     * @return mixed
     */
    public function forceDelete(User $user, ScratchCardAnswer $model)
    {
        return false;
    }
}
