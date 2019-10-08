<?php

namespace App\Http\Controllers;

use App\Command;
use App\Employee;
use App\Equipment;
use App\InterventionRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChartsController extends Controller
{
    public function stoppingTimes()
    {
        $values = array();
        for ($i = 0; $i < 52; $i++) {
            $values[] = 0;
        }
        return $values;
    }

    public function chartBymMachine($id, $year)
    {
        $values = InterventionRequest::GraphBymachine($id, $year);
        $stoppingTimes = $this->stoppingTimes();
        $interventionTimes = $this->stoppingTimes();
        foreach ($values as $key => $value) {
            $stopping_hour = Carbon::parse($value['stopping_hour']);
            $end_hour = Carbon::parse($value['end_hour']);
            $start_hour = Carbon::parse($value['start_hour']);
            $stoppingTimes[$end_hour->weekOfYear - 1] = (double)($stoppingTimes[$end_hour->weekOfYear - 1] + $stopping_hour->diffInHours($end_hour));
            $interventionTimes[$end_hour->weekOfYear - 1] = (double)($interventionTimes[$end_hour->weekOfYear - 1]) + $end_hour->diffInHours($start_hour);
        }
        $data = array();
        $data['stopping_times'] = $stoppingTimes;
        $data['intervention_times'] = $interventionTimes;
        return $data;
    }

    public function chartByAll($year)
    {
        $values = InterventionRequest::GraphByAll($year);
        $stoppingTimes = $this->stoppingTimes();
        $interventionTimes = $this->stoppingTimes();
        foreach ($values as $value) {
            $stopping_hour = Carbon::parse($value['stopping_hour']);
            $end_hour = Carbon::parse($value['end_hour']);
            $start_hour = Carbon::parse($value['start_hour']);
            $stoppingTimes[$end_hour->weekOfYear - 1] = (double)($stoppingTimes[$end_hour->weekOfYear - 1] + $stopping_hour->diffInHours($end_hour));
            $interventionTimes[$end_hour->weekOfYear - 1] = (double)($interventionTimes[$end_hour->weekOfYear - 1]) + $end_hour->diffInHours($start_hour);
        }
        $data = array();
        $data['stopping_times'] = $stoppingTimes;
        $data['intervention_times'] = $interventionTimes;
        return $data;
    }

    public function commandPercentage()
    {
        $percentagePending = Command::PercentagPending();
        if ($percentagePending != 'not available') {
            $data = array();
            $data['pending'] =floor($percentagePending) ;
            $data['valid']=100-floor($percentagePending);
            return $data;
        }
        else
            return 'not available';
    }

    public function manufacturers()
    {
        $result=Equipment::ChartByManufacturer();
        return $result;
    }

    public function suppliers()
    {
        $result=Equipment::ChartBySuppliers();
        return $result;
    }

    public function jobCount()
    {
        return Employee::JobCount();
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
