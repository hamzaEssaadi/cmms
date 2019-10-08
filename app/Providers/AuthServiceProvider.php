<?php

namespace App\Providers;

use App\Article;
use App\Employee;
use App\Employee_task;
use App\InterventionRequest;
use App\Jobposition;
use App\Location;
use App\Policies\ArticlePolicy;
use App\Policies\Employee_taskPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\InterventionRequestPolicy;
use App\Policies\JobpositionPolicy;
use App\Policies\LocationPolicy;
use App\Policies\PreventiveInterventionPolicy;
use App\Policies\ProviderPolicy;
use App\Policies\ReportPolicy;
use App\Policies\SalaryPolicy;
use App\Policies\TaskPolicy;
use App\Policies\TrainingPolicy;
use App\Policies\UserPolicy;
use App\Policies\WorkexceptionPolicy;
use App\Policies\WorkOrderPolicy;
use App\PreventiveIntervention;
use App\Provider;
use App\Report;
use App\Salary;
use App\Task;
use App\Training;
use App\User;
use App\Workexception;
use App\WorkOrder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Employee::class => EmployeePolicy::class,
        Jobposition::class => JobpositionPolicy::class,
        Workexception::class => WorkexceptionPolicy::class,
        Salary::class => SalaryPolicy::class,
        Training::class => TrainingPolicy::class,
        Provider::class => ProviderPolicy::class,
        Location::class => LocationPolicy::class,
        Article::class => ArticlePolicy::class,
        WorkOrder::class => WorkOrderPolicy::class,
        InterventionRequest::class=>InterventionRequestPolicy::class,
        PreventiveIntervention::class => PreventiveInterventionPolicy::class,
        Task::class=>TaskPolicy::class,
        Employee_task::class =>Employee_taskPolicy::class,
        Report::class=>ReportPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
