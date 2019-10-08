<?php

namespace App\Policies;

use App\User;
use App\PreventiveIntervention;
use Illuminate\Auth\Access\HandlesAuthorization;

class PreventiveInterventionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the preventive intervention.
     *
     * @param  \App\User  $user
     * @param  \App\PreventiveIntervention  $preventiveIntervention
     * @return mixed
     */
    public function view(User $user, PreventiveIntervention $preventiveIntervention)
    {
        //
    }

    /**
     * Determine whether the user can create preventive interventions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->role=='maintenance_manager')
            return true;
    }

    public function validation(User $user,PreventiveIntervention $preventiveIntervention)
    {

    }

    /**
     * Determine whether the user can update the preventive intervention.
     *
     * @param  \App\User  $user
     * @param  \App\PreventiveIntervention  $preventiveIntervention
     * @return mixed
     */
    public function update(User $user, PreventiveIntervention $preventiveIntervention)
    {
        if($user->employee_id==$preventiveIntervention->employee_id)
            return true;
    }

    /**
     * Determine whether the user can delete the preventive intervention.
     *
     * @param  \App\User  $user
     * @param  \App\PreventiveIntervention  $preventiveIntervention
     * @return mixed
     */
    public function delete(User $user, PreventiveIntervention $preventiveIntervention)
    {
        if($user->employee_id==$preventiveIntervention->employee_id)
            return true;
    }

    /**
     * Determine whether the user can restore the preventive intervention.
     *
     * @param  \App\User  $user
     * @param  \App\PreventiveIntervention  $preventiveIntervention
     * @return mixed
     */
    public function restore(User $user, PreventiveIntervention $preventiveIntervention)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the preventive intervention.
     *
     * @param  \App\User  $user
     * @param  \App\PreventiveIntervention  $preventiveIntervention
     * @return mixed
     */
    public function forceDelete(User $user, PreventiveIntervention $preventiveIntervention)
    {
        //
    }

    public function before(User $user,$ability)
    {
        if($user->role=='super_admin' && $ability!='create')
            return true;
        if($user->role=='maintenance_manager' && ($ability!='update' && $ability!='delete'))
            return true;
    }
}
