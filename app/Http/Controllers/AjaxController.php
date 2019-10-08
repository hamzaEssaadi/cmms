<?php

namespace App\Http\Controllers;

use App\Article;
use App\Command;
use App\InterventionRequest;
use App\Jobposition;
use App\PreventiveIntervention;
use App\User;
use App\WorkOrder;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AjaxController extends Controller
{

    public function articles()
    {
        if (Auth::user()->role == 'super_admin' or Auth::user()->role == 'stock_manager') {
            $query = Article::Ajax();
            return DataTables::of($query)->
            editColumn('code', function (Article $article) {
                return $article->code;
            })->
            addColumn('qte', function (Article $article) {
                $sum=$article->stocks()->sum('qte');
                return $sum;
            })->
            addColumn('error',function(Article $article){
                $list='';
                $haveErrorStock=0;
                $haveSupplyPointError=0;
                $label='';
                if($article->haveErrorsStock()==1) {
//                    $list .= "<span class='fa fa-warning color red'></span> Error Stock<br>";
                    $haveErrorStock=1;
                }
                if($article->haveSupplyPointError()==1) {
                    $haveSupplyPointError=1;
//                    $list .= "$br<span class='fa fa-warning color red'></span> Qte out of supply point<br>";
                }
                if($haveSupplyPointError==0 && $haveErrorStock==0)
                    return "<span class='label label-success'>No error</span>";
                if($haveSupplyPointError==1 && $haveErrorStock==0)
                    return "<span class='label label-danger'>SP error</span>";
                if($haveSupplyPointError==0 && $haveErrorStock==1)
                    return "<span class='label label-warning'>Cost error</span>";
                if($haveSupplyPointError==1 && $haveErrorStock==1)
                    return "<span class='label label-warning' style='background-color: purple;'>Double error</span>";

                return $list;

            })->
            addColumn('action', function (Article $article) {
                    $edithref = url('articles/' . $article->id . '/edit');
                    $detailhref = url('articles/' . $article->id);
                    $commandhref = route('commands', ['article' => $article->id]);
                    return "
           <div class=\"btn-group\">
                        <button data-toggle=\"dropdown\" class=\"btn btn-success dropdown-toggle btn-xs\" type=\"button\"
                                aria-expanded=\"false\">Select an action <span class=\"caret\"></span>
                        </button>
                        <ul role=\"menu\"  class=\"dropdown-menu\">
                            <li>
                            <a href='$edithref'><i class=\"fa fa-edit\"> Edit</i></a>
                            </li>
                            <li><a href='$detailhref'><i class=\"fa fa-eye\"> Details</i></a>
                            </li>
                            <li><a href='$commandhref'><i class=\"fa fa-cubes\"> Command list</i></a>
                            </li>
                        </ul>
                    </div>";
                })
                ->editColumn('added_in', function (Article $article) {
                    if($article->added_in==null)
                        return null;
                    $formated = date('d/m/Y', strtotime($article->added_in));
                    return "
                <span class='hidden'>" . $article->added_in . "</span>$formated";
                }
                )
                ->setRowClass(function () {

                })
                ->rawColumns(['added_in', 'action','error'])
                ->make(true);
        }
        return null;
    }

    public function commands()
    {
        if (Auth::user()->role == 'super_admin' or Auth::user()->role == 'stock_manager') {
            $query = Command::
            with('employee')->
            with('stock')->
            with('location')->
            with('article')->
            select('*');
            return DataTables::of($query)
                ->addColumn('article', function (Command $command) {
                    return $command->article->code;
                })
                ->addColumn('delivered_to', function (Command $command) {
                    return $command->employee->name;
                })
                ->editColumn('delivered_from', function (Command $command) {
                    return $command->stock->site . ' (' . $command->stock->location->code . ')';
                    return $command->s;
                })
                ->addColumn('location', function (Command $command) {
                    return $command->location->code;
                })
                ->addColumn('action', function (Command $command) {
                    $id = $command->id;
                    $onclick = "onclick=pass_command('$id')";
                    return "
                 <a href=\"#\" class=\"\" onclick=\"$onclick\" data-toggle=\"modal\"
                                   data-target=\".bs-example-modal-purposes\">
                                   <i class=\"fa fa-remove\"></i></a>
                ";
                })
                ->editColumn('date', function (Command $command) {
                    $formated = date('d/m/Y', strtotime($command->date));
                    return "<span class='hidden'>$command->date</span>$formated";
                }
                )
                ->editColumn('status', function (Command $command) {
                    if ($command->status == 'pending')
                        return "<span class='label label-warning'>pending</span>";
                    else
                        return "<span class='label label-success'>valid</span>";
                })
                ->rawColumns(['status', 'action', 'date'])
                ->make(true);
        } else
            return null;
    }

    public function requests()
    {
        if (Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager') {
            $query = InterventionRequest::Ajax();
        } else {
            $query = InterventionRequest::AjaxEmployee();
        }
        return DataTables::of($query)
            ->addColumn('written_by', function (InterventionRequest $request) {
                if ($request->employee_id == null)
                    return 'Director';
                return $request->employee->name;
            })
            ->addColumn('work_order_status', function (InterventionRequest $request) {
                if ($request->workOrder != null) {
                    if ($request->workOrder->status == 'pending')
                        return "<span class='label label-default' style='background-color: #BCBEC0'>pending...</span>";
                    else
                        return "<span class='label label-success'>completed</span>";
                } else
                    return "<span class='label label-danger' style='display: inline-block;width: 57px!important;'>unlinked</span>";
            })
//            ->editColumn('code',function (InterventionRequest $request){return $request->code; })
//            ->addColumn('machine', function (InterventionRequest $request) {
//                return $request->equipment->code;
//            })
            ->editColumn('date', function (InterventionRequest $request) {
                return "<span class='hidden'>$request->date</span>" . date('d/m/Y', strtotime($request->date));
            })
            ->editColumn('stopping_hour', function (InterventionRequest $request) {
                return "<span class='hidden'>$request->stopping_hour</span>" . date('d/m/Y H:i', strtotime($request->stopping_hour));
            })
            ->editColumn('start_hour', function (InterventionRequest $request) {
                if ($request->start_hour != null)
                    return "<span class='hidden'>$request->start_hour</span>" . date('d/m/Y H:i', strtotime($request->start_hour));
            })
            ->editColumn('end_hour', function (InterventionRequest $request) {
                if ($request->end_hour != null)
                    return "<span class='hidden'>$request->end_hour</span>" . date('d/m/Y H:i', strtotime($request->end_hour));
            })
            ->editColumn('status', function (InterventionRequest $request) {
                if ($request->status == 'pending')
                    return "<span class='label label-default' style='background-color: #BCBEC0;'>pending...</span>";
                elseif ($request->status == 'requested')
                    return "<span class='label label-warning'>requested</span>";
                else
                    return "<span class='label label-success' style='width: 58px!important;display: inline-block;'>valid</span>";
            })
            ->addColumn('action_one', function (InterventionRequest $request) {
                $html = "";
                if ($request->workOrder == null) {
                    if (Auth::user()->can('createOrder', InterventionRequest::class)) {
                        $route = route('request.order.create', ['interventionRequest' => $request->id]);
                        $html .= "<a href='$route'><i title='add work order' class='fa fa-plus'></i></a> ";
                    }
                } else {
                    $route = route('request.show.order', ['workOrder' => $request->workOrder->id]);
                    $html .= "<a href='$route'><i class='fa fa-eye' title='show work order'></i></a> ";
                }

                if (Auth::user()->can('validation', $request)) {
                    if ($request->status == 'pending' || $request->status == 'requested') {
                        $route = route('request.validate', ['interventionRequest' => $request->id]);
                        $html .= "<a href='$route'><i class='fa fa-check' title='validation'></i></a> ";
                    } else {
                        $id = $request->id;
                        $onclick = "onclick=pass_request('$id')";
                        $html .= "<a href='#' data-toggle='modal' $onclick data-target='#myModal'>
                        <i title='cancel validation' class='fa fa-undo'></i></a> ";
                    }
                }
                if (Auth::user()->can('update', $request)) {
                    $route = route('interventions-requests.edit', ['interventionRequest' => $request->id]);
                    $html .= "<a href='$route'><i class='fa fa-edit' title='edit'></i></a> ";
                }
                return $html;
            })
//            ->addColumn('cause', function (InterventionRequest $request) {
//                return $request->disfunction->code;
//            })
            ->rawColumns(['action_one', 'date', 'stopping_hour', 'start_hour', 'end_hour', 'work_order_status', 'status'])
            ->make(true);

    }

    public function orders()
    {
        if (Auth::user()->role != 'average_user')
            $query = WorkOrder::AjaxAll();
        else
            $query = WorkOrder::AjaxEmployee();
        return DataTables::of($query)
            ->editColumn('status', function (WorkOrder $workOrder) {
                if ($workOrder->status == 'pending')
                    return '<span class="label label-warning" style=\'background-color: #BCBEC0\'>pending...</span>';
                else
                    return '<span class="label label-success" style="width: 62px!important;display: inline-block">completed</span>';
            }
            )
            ->editColumn('demand_at', function (WorkOrder $workOrder) {
                $formated = date('d/m/Y', strtotime($workOrder->demand_at));
                return "<span class='hidden'>$workOrder->demand_at</span>" . $formated;
            }
            )
            ->editColumn('billable', function (WorkOrder $workOrder) {
                return $workOrder->billable ? 'yes' : 'no';
            })->editColumn('description',function(WorkOrder $workOrder)
            {
              return str_limit($workOrder->description,100);
            })
            ->addColumn('action', function (WorkOrder $workOrder) {
                $html = '';
                $user = Auth::user();
                if ($user->can('validate', $workOrder)) {
                    $route = route('validate.order', ['worker' => $workOrder->getWorker()->id]);
                    if ($workOrder->isValid($user->employee_id) == 0) {
                        $html .= "<a href='$route'><i title='validation' class='fa fa-check'></i></a> ";
                    } else {
                        $html .= "<a href='$route'><i title='cancel validation' class='fa fa-undo'></i></a> ";
                    }
                }
                $route = route('work-orders.show', ['workOrder' => $workOrder->id]);
                $html .= "<a href='$route'><i title='details' class='fa fa-eye'></i></a><br>";
                if ($user->can('update', $workOrder)) {
                    $route = route('work-orders.edit', ['workOrder' => $workOrder->id]);
                    $html .= "<a href='$route'><i title='edit' class='fa fa-edit'></i></a> ";
                }
                if ($user->can('delete', $workOrder)) {
                    $id = $workOrder->id;
                    $click = "onclick=pass_order('$id')";
                    $html .= "<a href='#'><i title='delete work order' data-target='.bs-example-modal-delete' 
                                            data-toggle='modal'
                                            $click class='fa fa-trash'
                                            ></i></a> ";
                }
                return $html;
            }
            )
            ->setRowClass(function (WorkOrder $workOrder) {
                return $workOrder->status == 'pending' ? 'bg bg-info' : '';
            })
            ->rawColumns(['status', 'demand_at', 'action'])
            ->make(true);
    }

    public function preventive()
    {
        $query = PreventiveIntervention::Ajax();
        return DataTables::of($query)
            ->editColumn('status', function (PreventiveIntervention $preventiveIntervention) {
                $class = '';
                if ($preventiveIntervention->status == 'pending')
                    $class = 'label label-default';
                elseif ($preventiveIntervention->status == 'completed')
                    $class = 'label label-success';
                else
                    $class = 'label label-danger';
                return "<span class='$class' >$preventiveIntervention->status</span>";
            })
//            ->editColumn('date',function (PreventiveIntervention $intervention)
//            {
//                $formated=date('d/m/Y m:i',strtotime($intervention->date));
//                return "<span class='hidden'>$intervention->date</span>$formated";
//            }
//            )
            ->editColumn('intervention_start', function (PreventiveIntervention $intervention) {
                $formated = date('d/m/Y H:i', strtotime($intervention->intervention_start));
                return "<span class='hidden'>$intervention->intervention_start</span>$formated";
            }
            )
            ->editColumn('intervention_end', function (PreventiveIntervention $intervention) {
                $formated = date('d/m/Y H:i', strtotime($intervention->intervention_end));
                return "<span class='hidden'>$intervention->intervention_end</span>$formated";
            }
            )
            ->addColumn('action', function (PreventiveIntervention $preventiveIntervention) {
                $html = '';
                if (Auth::user()->can('update', $preventiveIntervention)) {
                    $route = route('preventive-interventions.edit', ['preventiveIntervention' => $preventiveIntervention->id]);
                    $html .= "<a href='$route'><i title='Edit' class='fa fa-edit'></i></a> ";
                }

                if (Auth::user()->can('validation', $preventiveIntervention)) {
                    $id = $preventiveIntervention->id;
                    if ($preventiveIntervention->status != 'completed') {
                        $route = route('validate.preventive', ['preventiveIntervention' => $id]);
                        $html .= "<a href='$route'><i title='validate intervention' class='fa fa-check'></i></a> ";
                    } else {
                        $onclick = "onclick=pass_preventive('$id')";
                        $html .= "<a href='#' data-toggle='modal' $onclick data-target='#validation'>
                            <i class='fa fa-undo' title='cancel validation'></i>
                            </a> ";
                    }
                }
                if (Auth::user()->can('delete', $preventiveIntervention)) {
                    $onclick = "onclick=delete_provention('$id')";
                    $html .= "<a href='#' data-toggle='modal' $onclick data-target='#delete'>
                            <i class='fa fa-trash' title='delete intervention'></i>
                            </a> ";
                }
                return $html;
            }
            )
            ->rawColumns(['action', 'status', 'intervention_end', 'intervention_start'])
            ->make(true);
    }


    public function __construct()
    {
        $this->middleware('auth');
    }


}
