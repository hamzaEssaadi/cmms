<?php

namespace App\Policies;

use App\User;
use App\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the location.
     *
     * @param  \App\User $user
     * @param  \App\Location $location
     * @return mixed
     */
    public function view(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can create locations.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    public function index(User $user)
    {

    }

    /**
     * Determine whether the user can update the location.
     *
     * @param  \App\User $user
     * @param  \App\Location $location
     * @return mixed
     */
    public function update(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can delete the location.
     *
     * @param  \App\User $user
     * @param  \App\Location $location
     * @return mixed
     */
    public function delete(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can restore the location.
     *
     * @param  \App\User $user
     * @param  \App\Location $location
     * @return mixed
     */
    public function restore(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the location.
     *
     * @param  \App\User $user
     * @param  \App\Location $location
     * @return mixed
     */
    public function forceDelete(User $user, Location $location)
    {
        //
    }

    public function before(User $user, $ability)
    {
        if ($user->role == 'super_admin' || $user->role == 'stock_manager') {
            return true;
        }
        return false;
    }
}
