<?php

namespace App\Http\Controllers;

use App\Article;
use App\Command;
use App\Employee;
use App\InterventionRequest;
use App\PreventiveIntervention;
use App\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class DashboardController extends Controller
{
    public function index()
    {
        $commands=Command::select('id','date','status')->where('status','pending')->get();
        foreach ($commands as $command)
        {
            $date=Carbon::parse($command->date);
            if(!$date->isFuture() or $date->isToday())
            {
                $command->status='valid';
                $command->save();
            }
        }
        $orderCount=WorkOrder::Number();
        $requestCount=InterventionRequest::Number();
        $preventiveInterventionCount=PreventiveIntervention::Number();
        return view('dashboard',compact('orderCount','requestCount','preventiveInterventionCount'));
    }


}
