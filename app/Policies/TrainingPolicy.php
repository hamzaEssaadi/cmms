<?php

namespace App\Policies;

use App\User;
use App\Training;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrainingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the training.
     *
     * @param  \App\User  $user
     * @param  \App\Training  $training
     * @return mixed
     */
    public function view(User $user, Training $training)
    {
        //
    }

    /**
     * Determine whether the user can create trainings.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the training.
     *
     * @param  \App\User  $user
     * @param  \App\Training  $training
     * @return mixed
     */
    public function update(User $user, Training $training)
    {
        //
    }

    /**
     * Determine whether the user can delete the training.
     *
     * @param  \App\User  $user
     * @param  \App\Training  $training
     * @return mixed
     */
    public function delete(User $user, Training $training)
    {
        //
    }

    /**
     * Determine whether the user can restore the training.
     *
     * @param  \App\User  $user
     * @param  \App\Training  $training
     * @return mixed
     */
    public function restore(User $user, Training $training)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the training.
     *
     * @param  \App\User  $user
     * @param  \App\Training  $training
     * @return mixed
     */
    public function forceDelete(User $user, Training $training)
    {
        //
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
