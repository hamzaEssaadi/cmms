<?php

namespace App\Policies;

use App\User;
use App\Jobposition;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobpositionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the jobposition.
     *
     * @param  \App\User  $user
     * @param  \App\Jobposition  $jobposition
     * @return mixed
     */
    public function view(User $user, Jobposition $jobposition)
    {
        //
    }

    /**
     * Determine whether the user can create jobpositions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the jobposition.
     *
     * @param  \App\User  $user
     * @param  \App\Jobposition  $jobposition
     * @return mixed
     */
    public function update(User $user, Jobposition $jobposition)
    {
        //
    }

    /**
     * Determine whether the user can delete the jobposition.
     *
     * @param  \App\User  $user
     * @param  \App\Jobposition  $jobposition
     * @return mixed
     */
    public function delete(User $user, Jobposition $jobposition)
    {
        //
    }

    /**
     * Determine whether the user can restore the jobposition.
     *
     * @param  \App\User  $user
     * @param  \App\Jobposition  $jobposition
     * @return mixed
     */
    public function restore(User $user, Jobposition $jobposition)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the jobposition.
     *
     * @param  \App\User  $user
     * @param  \App\Jobposition  $jobposition
     * @return mixed
     */
    public function forceDelete(User $user, Jobposition $jobposition)
    {

    }

    public function index(User $user)
    {

    }

    public function before(User $user,$ability)
    {
        if(($user->role=='rh_manager' || $user->role=='super_admin'))
            return true;
        else
            return false;
    }
}
