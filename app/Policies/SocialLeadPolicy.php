<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SocialLead;
use Illuminate\Auth\Access\HandlesAuthorization;

class SocialLeadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the socialLead can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list socialleads');
    }

    /**
     * Determine whether the socialLead can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SocialLead  $model
     * @return mixed
     */
    public function view(User $user, SocialLead $model)
    {
        return $user->hasPermissionTo('view socialleads');
    }

    /**
     * Determine whether the socialLead can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create socialleads');
    }

    /**
     * Determine whether the socialLead can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SocialLead  $model
     * @return mixed
     */
    public function update(User $user, SocialLead $model)
    {
        return $user->hasPermissionTo('update socialleads');
    }

    /**
     * Determine whether the socialLead can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SocialLead  $model
     * @return mixed
     */
    public function delete(User $user, SocialLead $model)
    {
        return $user->hasPermissionTo('delete socialleads');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SocialLead  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete socialleads');
    }

    /**
     * Determine whether the socialLead can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SocialLead  $model
     * @return mixed
     */
    public function restore(User $user, SocialLead $model)
    {
        return false;
    }

    /**
     * Determine whether the socialLead can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SocialLead  $model
     * @return mixed
     */
    public function forceDelete(User $user, SocialLead $model)
    {
        return false;
    }
}
