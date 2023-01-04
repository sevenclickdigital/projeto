<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RatingGoogleBusiness;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingGoogleBusinessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the ratingGoogleBusiness can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list ratinggooglebusinesses');
    }

    /**
     * Determine whether the ratingGoogleBusiness can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RatingGoogleBusiness  $model
     * @return mixed
     */
    public function view(User $user, RatingGoogleBusiness $model)
    {
        return $user->hasPermissionTo('view ratinggooglebusinesses');
    }

    /**
     * Determine whether the ratingGoogleBusiness can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create ratinggooglebusinesses');
    }

    /**
     * Determine whether the ratingGoogleBusiness can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RatingGoogleBusiness  $model
     * @return mixed
     */
    public function update(User $user, RatingGoogleBusiness $model)
    {
        return $user->hasPermissionTo('update ratinggooglebusinesses');
    }

    /**
     * Determine whether the ratingGoogleBusiness can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RatingGoogleBusiness  $model
     * @return mixed
     */
    public function delete(User $user, RatingGoogleBusiness $model)
    {
        return $user->hasPermissionTo('delete ratinggooglebusinesses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RatingGoogleBusiness  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete ratinggooglebusinesses');
    }

    /**
     * Determine whether the ratingGoogleBusiness can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RatingGoogleBusiness  $model
     * @return mixed
     */
    public function restore(User $user, RatingGoogleBusiness $model)
    {
        return false;
    }

    /**
     * Determine whether the ratingGoogleBusiness can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RatingGoogleBusiness  $model
     * @return mixed
     */
    public function forceDelete(User $user, RatingGoogleBusiness $model)
    {
        return false;
    }
}
