<?php

namespace App\Policies;

use App\User;
use App\InterventionRequest;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class InterventionRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the intervention request.
     *
     * @param  \App\User  $user
     * @param  \App\InterventionRequest  $interventionRequest
     * @return mixed
     */
    public function view(User $user, InterventionRequest $interventionRequest)
    {
        //
    }

    public function createOrder(User $user)
    {
        if($user->role=='maintenance_manager') {
            return true;
        }
    }

    public function validation(User $user,InterventionRequest $interventionRequest)
    {
        if($user->role=='maintenance_manager')
            return true;
    }

    /**
     * Determine whether the user can create intervention requests.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->role=='super_admin')
            return false;
        return true;
    }

    /**
     * Determine whether the user can update the intervention request.
     *
     * @param  \App\User  $user
     * @param  \App\InterventionRequest  $interventionRequest
     * @return mixed
     */
    public function update(User $user, InterventionRequest $interventionRequest)
    {
        if($user->role=='super_admin' || $user->role=='maintenance_manager')
            return true;
        if($user->employee_id==$interventionRequest->employee_id)
            return true;
    }

    /**
     * Determine whether the user can delete the intervention request.
     *
     * @param  \App\User  $user
     * @param  \App\InterventionRequest  $interventionRequest
     * @return mixed
     */
    public function delete(User $user, InterventionRequest $interventionRequest)
    {
        //
    }

    /**
     * Determine whether the user can restore the intervention request.
     *
     * @param  \App\User  $user
     * @param  \App\InterventionRequest  $interventionRequest
     * @return mixed
     */
    public function restore(User $user, InterventionRequest $interventionRequest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the intervention request.
     *
     * @param  \App\User  $user
     * @param  \App\InterventionRequest  $interventionRequest
     * @return mixed
     */
    public function forceDelete(User $user, InterventionRequest $interventionRequest)
    {
        //
    }

}
