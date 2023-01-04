<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CategoryProduct;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the categoryProduct can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list categoryproducts');
    }

    /**
     * Determine whether the categoryProduct can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CategoryProduct  $model
     * @return mixed
     */
    public function view(User $user, CategoryProduct $model)
    {
        return $user->hasPermissionTo('view categoryproducts');
    }

    /**
     * Determine whether the categoryProduct can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create categoryproducts');
    }

    /**
     * Determine whether the categoryProduct can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CategoryProduct  $model
     * @return mixed
     */
    public function update(User $user, CategoryProduct $model)
    {
        return $user->hasPermissionTo('update categoryproducts');
    }

    /**
     * Determine whether the categoryProduct can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CategoryProduct  $model
     * @return mixed
     */
    public function delete(User $user, CategoryProduct $model)
    {
        return $user->hasPermissionTo('delete categoryproducts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CategoryProduct  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete categoryproducts');
    }

    /**
     * Determine whether the categoryProduct can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CategoryProduct  $model
     * @return mixed
     */
    public function restore(User $user, CategoryProduct $model)
    {
        return false;
    }

    /**
     * Determine whether the categoryProduct can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CategoryProduct  $model
     * @return mixed
     */
    public function forceDelete(User $user, CategoryProduct $model)
    {
        return false;
    }
}
