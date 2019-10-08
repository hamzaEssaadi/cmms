<?php

namespace App\Policies;

use App\User;
use App\Employee_task;
use Illuminate\Auth\Access\HandlesAuthorization;

class Employee_taskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the employee_task.
     *
     * @param  \App\User  $user
     * @param  \App\Employee_task  $employeeTask
     * @return mixed
     */
    public function view(User $user, Employee_task $employeeTask)
    {
        //
    }

    /**
     * Determine whether the user can create employee_tasks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    public function validation(User $user,Employee_task $employee_task)
    {
        if($user->employee_id==$employee_task->employee_id)
            return true;
    }

    /**
     * Determine whether the user can update the employee_task.
     *
     * @param  \App\User  $user
     * @param  \App\Employee_task  $employeeTask
     * @return mixed
     */
    public function update(User $user, Employee_task $employeeTask)
    {
        //
    }

    /**
     * Determine whether the user can delete the employee_task.
     *
     * @param  \App\User  $user
     * @param  \App\Employee_task  $employeeTask
     * @return mixed
     */
    public function delete(User $user, Employee_task $employeeTask)
    {
        //
    }

    /**
     * Determine whether the user can restore the employee_task.
     *
     * @param  \App\User  $user
     * @param  \App\Employee_task  $employeeTask
     * @return mixed
     */
    public function restore(User $user, Employee_task $employeeTask)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the employee_task.
     *
     * @param  \App\User  $user
     * @param  \App\Employee_task  $employeeTask
     * @return mixed
     */
    public function forceDelete(User $user, Employee_task $employeeTask)
    {
        //
    }
}
