<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the tenant can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list tenants');
    }

    /**
     * Determine whether the tenant can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Tenant  $model
     * @return mixed
     */
    public function view(User $user, Tenant $model)
    {
        return $user->hasPermissionTo('view tenants');
    }

    /**
     * Determine whether the tenant can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create tenants');
    }

    /**
     * Determine whether the tenant can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Tenant  $model
     * @return mixed
     */
    public function update(User $user, Tenant $model)
    {
        return $user->hasPermissionTo('update tenants');
    }

    /**
     * Determine whether the tenant can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Tenant  $model
     * @return mixed
     */
    public function delete(User $user, Tenant $model)
    {
        return $user->hasPermissionTo('delete tenants');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Tenant  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete tenants');
    }

    /**
     * Determine whether the tenant can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Tenant  $model
     * @return mixed
     */
    public function restore(User $user, Tenant $model)
    {
        return false;
    }

    /**
     * Determine whether the tenant can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Tenant  $model
     * @return mixed
     */
    public function forceDelete(User $user, Tenant $model)
    {
        return false;
    }
}
