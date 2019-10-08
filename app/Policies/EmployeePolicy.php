<?php

namespace App\Policies;

use App\User;
use App\Employee;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the employee.
     *
     * @param  \App\User $user
     * @param  \App\Employee $employee
     * @return mixed
     */
    public function view(User $user, Employee $employee)
    {
        if ($employee->user == null)
            return false;
        if ($employee->id == $user->employee->id)
            return true;
    }

    public function index(User $user)
    {

    }

    /**
     * Determine whether the user can create employees.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {

    }

    /**
     * Determine whether the user can update the employee.
     *
     * @param  \App\User $user
     * @param  \App\Employee $employee
     * @return mixed
     */
    public function update(User $user, Employee $employee)
    {
        if ($user->role == 'rh_manager') {
            if ($employee->user == null)
                return true;
            if ($employee->user->role == 'rh_manager')
                return false;
            else
                return true;
        }

//        if ($employee->user == null) {
//            if ($user->role == 'rh_manager')
//                return true;
//            else
//                return false;
//        }
//        if ($employee->user->role == 'rh_manager')
//            return false;
//        if ($user->employee->id != $employee->id)
//            return false;
//        return true;
    }

    /**
     * Determine whether the user can delete the employee.
     *
     * @param  \App\User $user
     * @param  \App\Employee $employee
     * @return mixed
     */
    public function delete(User $user, Employee $employee)
    {
        if ($user->role == 'rh_manager') {
            if ($employee->user == null)
                return true;
            if ($employee->user->role == 'rh_manager')
                return false;
            return true;
        }
    }

    /**
     * Determine whether the user can restore the employee.
     *
     * @param  \App\User $user
     * @param  \App\Employee $employee
     * @return mixed
     */
    public function restore(User $user, Employee $employee)
    {
        if ($user->role == 'rh_manager') {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the employee.
     *
     * @param  \App\User $user
     * @param  \App\Employee $employee
     * @return mixed
     */
    public function forceDelete(User $user, Employee $employee)
    {
        //
    }

    public function before($user, $ability)
    {
        if ($user->role == 'super_admin' || ($user->role == 'rh_manager' && ($ability == 'create' || $ability == 'view' || $ability == 'index')))
            return true;
    }
}
