<?php

namespace App\Policies;

use App\User;
use App\Workexception;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkexceptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the workexception.
     *
     * @param  \App\User  $user
     * @param  \App\Workexception  $workexception
     * @return mixed
     */
    public function view(User $user, Workexception $workexception)
    {
        //
    }

    /**
     * Determine whether the user can create workexceptions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the workexception.
     *
     * @param  \App\User  $user
     * @param  \App\Workexception  $workexception
     * @return mixed
     */
    public function update(User $user, Workexception $workexception)
    {
        //
    }

    /**
     * Determine whether the user can delete the workexception.
     *
     * @param  \App\User  $user
     * @param  \App\Workexception  $workexception
     * @return mixed
     */
    public function delete(User $user, Workexception $workexception)
    {
        //
    }

    /**
     * Determine whether the user can restore the workexception.
     *
     * @param  \App\User  $user
     * @param  \App\Workexception  $workexception
     * @return mixed
     */
    public function restore(User $user, Workexception $workexception)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the workexception.
     *
     * @param  \App\User  $user
     * @param  \App\Workexception  $workexception
     * @return mixed
     */
    public function forceDelete(User $user, Workexception $workexception)
    {

    }

    public function before(User $user,$ability)
    {
        if($user->role=='rh_manager' || $user->role=='super_admin')
        {
            return true;
        }
        return false;
    }
}
