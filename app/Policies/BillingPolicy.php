<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Billing;
use Illuminate\Auth\Access\HandlesAuthorization;

class BillingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the billing can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list billings');
    }

    /**
     * Determine whether the billing can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Billing  $model
     * @return mixed
     */
    public function view(User $user, Billing $model)
    {
        return $user->hasPermissionTo('view billings');
    }

    /**
     * Determine whether the billing can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create billings');
    }

    /**
     * Determine whether the billing can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Billing  $model
     * @return mixed
     */
    public function update(User $user, Billing $model)
    {
        return $user->hasPermissionTo('update billings');
    }

    /**
     * Determine whether the billing can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Billing  $model
     * @return mixed
     */
    public function delete(User $user, Billing $model)
    {
        return $user->hasPermissionTo('delete billings');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Billing  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete billings');
    }

    /**
     * Determine whether the billing can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Billing  $model
     * @return mixed
     */
    public function restore(User $user, Billing $model)
    {
        return false;
    }

    /**
     * Determine whether the billing can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Billing  $model
     * @return mixed
     */
    public function forceDelete(User $user, Billing $model)
    {
        return false;
    }
}
