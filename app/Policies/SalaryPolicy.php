<?php

namespace App\Policies;

use App\User;
use App\Salary;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalaryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the salary.
     *
     * @param  \App\User  $user
     * @param  \App\Salary  $salary
     * @return mixed
     */
    public function view(User $user, Salary $salary)
    {
        //
    }

    /**
     * Determine whether the user can create salaries.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the salary.
     *
     * @param  \App\User  $user
     * @param  \App\Salary  $salary
     * @return mixed
     */
    public function update(User $user, Salary $salary)
    {
        //
    }

    /**
     * Determine whether the user can delete the salary.
     *
     * @param  \App\User  $user
     * @param  \App\Salary  $salary
     * @return mixed
     */
    public function delete(User $user, Salary $salary)
    {
        //
    }

    /**
     * Determine whether the user can restore the salary.
     *
     * @param  \App\User  $user
     * @param  \App\Salary  $salary
     * @return mixed
     */
    public function restore(User $user, Salary $salary)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the salary.
     *
     * @param  \App\User  $user
     * @param  \App\Salary  $salary
     * @return mixed
     */
    public function forceDelete(User $user, Salary $salary)
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
