<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the lead can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list leads');
    }

    /**
     * Determine whether the lead can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Lead  $model
     * @return mixed
     */
    public function view(User $user, Lead $model)
    {
        return $user->hasPermissionTo('view leads');
    }

    /**
     * Determine whether the lead can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create leads');
    }

    /**
     * Determine whether the lead can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Lead  $model
     * @return mixed
     */
    public function update(User $user, Lead $model)
    {
        return $user->hasPermissionTo('update leads');
    }

    /**
     * Determine whether the lead can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Lead  $model
     * @return mixed
     */
    public function delete(User $user, Lead $model)
    {
        return $user->hasPermissionTo('delete leads');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Lead  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete leads');
    }

    /**
     * Determine whether the lead can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Lead  $model
     * @return mixed
     */
    public function restore(User $user, Lead $model)
    {
        return false;
    }

    /**
     * Determine whether the lead can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Lead  $model
     * @return mixed
     */
    public function forceDelete(User $user, Lead $model)
    {
        return false;
    }
}
