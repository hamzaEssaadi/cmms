<?php

namespace App\Policies;

use App\User;
use App\WorkOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the work order.
     *
     * @param  \App\User $user
     * @param  \App\WorkOrder $workOrder
     * @return mixed
     */
    public function view(User $user, WorkOrder $workOrder)
    {

    }

    /**
     * Determine whether the user can create work orders.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
         if($user->role=='average_user' || $user->role=='super_admin')
             return false;
         return true;
    }

    /**
     * Determine whether the user can update the work order.
     *
     * @param  \App\User $user
     * @param  \App\WorkOrder $workOrder
     * @return mixed
     */
    public function update(User $user, WorkOrder $workOrder)
    {
        if($user->employee_id==$workOrder->employee_id) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the work order.
     *
     * @param  \App\User $user
     * @param  \App\WorkOrder $workOrder
     * @return mixed
     */
    public function delete(User $user, WorkOrder $workOrder)
    {
        if($user->employee_id==$workOrder->employee_id)
            return true;
    }

    /**
     * Determine whether the user can restore the work order.
     *
     * @param  \App\User $user
     * @param  \App\WorkOrder $workOrder
     * @return mixed
     */
    public function restore(User $user, WorkOrder $workOrder)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the work order.
     *
     * @param  \App\User $user
     * @param  \App\WorkOrder $workOrder
     * @return mixed
     */
    public function forceDelete(User $user, WorkOrder $workOrder)
    {

    }

    public function validate(User $user, WorkOrder $workOrder)
    {
//        if ($user->role == 'super_admin')
//            return true;
        if ($workOrder->belongToEmployee($user->employee_id))
            return true;
        return false;
    }

    public function before(User $user, $ability)
    {
        if ($user->role == 'super_admin' and ($ability!='validate' and $ability!='create'))
            return true;

    }
}
