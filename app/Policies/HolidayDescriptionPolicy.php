<?php

namespace App\Policies;

use App\Models\User;
use App\Models\HolidayDescription;
use Illuminate\Auth\Access\HandlesAuthorization;

class HolidayDescriptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the holidayDescription can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list holidaydescriptions');
    }

    /**
     * Determine whether the holidayDescription can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HolidayDescription  $model
     * @return mixed
     */
    public function view(User $user, HolidayDescription $model)
    {
        return $user->hasPermissionTo('view holidaydescriptions');
    }

    /**
     * Determine whether the holidayDescription can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create holidaydescriptions');
    }

    /**
     * Determine whether the holidayDescription can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HolidayDescription  $model
     * @return mixed
     */
    public function update(User $user, HolidayDescription $model)
    {
        return $user->hasPermissionTo('update holidaydescriptions');
    }

    /**
     * Determine whether the holidayDescription can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HolidayDescription  $model
     * @return mixed
     */
    public function delete(User $user, HolidayDescription $model)
    {
        return $user->hasPermissionTo('delete holidaydescriptions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HolidayDescription  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete holidaydescriptions');
    }

    /**
     * Determine whether the holidayDescription can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HolidayDescription  $model
     * @return mixed
     */
    public function restore(User $user, HolidayDescription $model)
    {
        return false;
    }

    /**
     * Determine whether the holidayDescription can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HolidayDescription  $model
     * @return mixed
     */
    public function forceDelete(User $user, HolidayDescription $model)
    {
        return false;
    }
}
