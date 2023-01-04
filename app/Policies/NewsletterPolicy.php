<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Newsletter;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsletterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the newsletter can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list newsletters');
    }

    /**
     * Determine whether the newsletter can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Newsletter  $model
     * @return mixed
     */
    public function view(User $user, Newsletter $model)
    {
        return $user->hasPermissionTo('view newsletters');
    }

    /**
     * Determine whether the newsletter can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create newsletters');
    }

    /**
     * Determine whether the newsletter can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Newsletter  $model
     * @return mixed
     */
    public function update(User $user, Newsletter $model)
    {
        return $user->hasPermissionTo('update newsletters');
    }

    /**
     * Determine whether the newsletter can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Newsletter  $model
     * @return mixed
     */
    public function delete(User $user, Newsletter $model)
    {
        return $user->hasPermissionTo('delete newsletters');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Newsletter  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete newsletters');
    }

    /**
     * Determine whether the newsletter can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Newsletter  $model
     * @return mixed
     */
    public function restore(User $user, Newsletter $model)
    {
        return false;
    }

    /**
     * Determine whether the newsletter can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Newsletter  $model
     * @return mixed
     */
    public function forceDelete(User $user, Newsletter $model)
    {
        return false;
    }
}
