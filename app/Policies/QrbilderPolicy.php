<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Qrbilder;
use Illuminate\Auth\Access\HandlesAuthorization;

class QrbilderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the qrbilder can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list qrbilders');
    }

    /**
     * Determine whether the qrbilder can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Qrbilder  $model
     * @return mixed
     */
    public function view(User $user, Qrbilder $model)
    {
        return $user->hasPermissionTo('view qrbilders');
    }

    /**
     * Determine whether the qrbilder can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create qrbilders');
    }

    /**
     * Determine whether the qrbilder can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Qrbilder  $model
     * @return mixed
     */
    public function update(User $user, Qrbilder $model)
    {
        return $user->hasPermissionTo('update qrbilders');
    }

    /**
     * Determine whether the qrbilder can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Qrbilder  $model
     * @return mixed
     */
    public function delete(User $user, Qrbilder $model)
    {
        return $user->hasPermissionTo('delete qrbilders');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Qrbilder  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete qrbilders');
    }

    /**
     * Determine whether the qrbilder can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Qrbilder  $model
     * @return mixed
     */
    public function restore(User $user, Qrbilder $model)
    {
        return false;
    }

    /**
     * Determine whether the qrbilder can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Qrbilder  $model
     * @return mixed
     */
    public function forceDelete(User $user, Qrbilder $model)
    {
        return false;
    }
}
