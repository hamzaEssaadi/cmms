@extends('layout.admin')
@section('title') Employee profile @endsection
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@stop

@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        @can('index',$employee)
        <li><a href="{{url('employees')}}">Employees management </a></li>
        @endcan
        <li class="active"><strong>Show</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>Employee's profile</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    @php
        if(!session()->has('tab'))
        $tab='';
        else
        $tab=session()->get('tab');
    @endphp
    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
        <div class="profile_img">
            <div id="crop-avatar">
                <!-- Current avatar -->
                <img class="img-responsive avatar-view" src="{{asset('emplys/images/'.$employee->photo())}}" alt="Avatar"
                     title="Change the avatar">
            </div>
        </div>
        <h3>{{$employee->name}}</h3>
        <ul class="list-unstyled user_data">
            <li><i class="fa fa-map-marker user-profile-icon"></i> {{str_limit(ucfirst($employee->address),20)}}
            </li>
            <li>
                <i class="fa fa-briefcase user-profile-icon"></i> {{ucfirst($employee->jobposition->code)}}
            </li>
            <li class="m-top-xs">
                <i class="fa fa-envelope"></i>
                {{$employee->email}}
            </li>
            <li>
                <i class="fa fa-flag"> </i>
                {{$employee->nationality}}
            </li>
            <li><i class="fa fa-phone"></i> {{$employee->phone}}</li>
            <li><i class="fa fa-calendar"></i> {{date('d/m/Y',strtotime($employee->hiring_date))}}</li>
        </ul>
        @can('update',$employee)
            <a href="{{url('employees/'.$employee->id.'/edit')}}" class="btn btn-success"><i
                        class="fa fa-edit m-right-xs"></i> Edit Employee</a>
            <br/>
        @endcan
    </div>
    <div class="col-md-9 col-sm-9 col-xs-12">
        @if(session()->has('success_added'))
        <center>
            <div class="alert alert-success">
                {{session()->get('success_added')}}
            </div>
        </center>
        @endif
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="@if($tab=='' or $tab=='exceptions') active @endif"><a href="#tab_content3" role="tab" id="profile-tab2"
                                                          data-toggle="tab"
                                                          aria-expanded="false">Work Exceptions</a>
                </li>
                <li role="presentation" class="@if($tab=='salaries') active @endif"><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab"
                                                    aria-expanded="false">Salaries</a>
                </li>
                <li role="presentation" class="@if($tab=='trainings') active @endif"><a href="#tab_content1" id="home-tab" role="tab"
                                                    data-toggle="tab" aria-expanded="true">Trainings</a>
                </li>


            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade @if($tab=='trainings') active in @endif" id="tab_content1" aria-labelledby="home-tab">
                    <!-- start recent activity -->
                    @if(session()->has('success'))
                        <center>
                            <div style="width: 70%;" class="alert alert-success ">
                                <b>{{session()->get('success')}}</b>
                            </div>
                        </center>
                    @endif
                    <ul class="messages">
                        @foreach($employee->trainings()->orderBy('date_end','desc')->get() as $training)
                            <li>
                                <div class="message_date">
                                    <br>
                                    @can('update',$training)
                                        <a href="{{url('trainings/'.$training->id.'/edit')}}"
                                           class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a><br>
                                    @endcan
                                    @can('delete',$training)
                                        <a href="#" style="margin-left: 10px;" class="btn btn-danger btn-xs"
                                           data-toggle="modal"
                                           onclick="pass_training('{{$training->id}}')"
                                           data-target=".bs-example-modal-training"><i
                                                    class="fa fa-remove"></i></a>
                                    @endcan
                                </div>
                                <div class="message_wrapper">
                                    <h4 class="heading">{{$training->title}}</h4>
                                    <blockquote class="message">
                                        {{str_limit($training->description,150)}}
                                    </blockquote>
                                    <p><i>{{$training->note}}</i></p>
                                    <p class="url">
                                        <span class="fs1 text-info" aria-hidden="true" data-icon="" ></span>
                                        <i class="fa fa-calendar"></i>
                                        {{date('d/m/Y',strtotime($training->date_start))}}
                                        => {{date('d/m/Y',strtotime($training->date_end))}}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                        <br>
                        @can('create',\App\Training::class)
                            <center>
                                <a class="btn btn-success" href="{{url('trainings/'.$employee->id)}}">Add a new
                                    training</a>
                            </center>
                        @endcan
                    </ul>
                    {{--modal for salaries--}}
                    <div class="modal fade bs-example-modal-training" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel2">Confirmation</h4>
                                </div>
                                <div class="modal-body">
                                    <h4>Warning</h4>
                                    <h6><strong>Are you sure to delete this training?!</strong></h6>
                                </div>
                                <form id="delete_training_form" method="post">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                        {{csrf_field()}}
                                        {{method_field('delete')}}
                                        <button type="submit" class="btn btn-danger">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- / end  salaries's modal -->
                </div>
                <div role="tabpanel" class="tab-pane fade @if($tab=='salaries') active in @endif" id="tab_content2" aria-labelledby="profile-tab">
                    @if(session()->has('success_salary'))
                        <center>
                            <div style="width: 70%;" class="alert alert-success ">
                                <b>{{session()->get('success_salary')}}</b>
                            </div>
                        </center>
                    @endif
                    @can('create',\App\Salary::class)
                        <div class="pull-right">
                            <a href="{{url('salaries/'.$employee->id)}}" class="btn btn-primary">Add a new salary</a>
                        </div>
                    @endcan
                    <table class="table table-hover" id="salaries_table">
                        <thead>
                        <tr>
                            <th>Salary type</th>
                            <th>Period start</th>
                            <th>Period end</th>
                            <th>Period by days</th>
                            <th>Date of payment</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employee->salaries as $salary)
                            <tr>
                                <td>{{$salary->type}}</td>
                                <td><span class="hidden">{{$salary->start_date}}</span>{{date('d/m/Y H:i',strtotime($salary->start_date))}}</td>
{{--                                <td>{{$salary->start_date}}</td>--}}
                                <td><span class="hidden">{{$salary->end_date}}</span>{{date('d/m/Y H:i',strtotime($salary->end_date))}}</td>
{{--                                <td>{{$salary->end_date}}</td>--}}
                                <td>{{\Carbon\Carbon::parse($salary->start_date)->diffInDays($salary->end_date)}} days
                                </td>
                                {{--<td>{{date('d/m/Y',strtotime($salary->payment_date))}}</td>--}}
                                <td><span class="hidden">{{$salary->payment_date}}</span>{{date('d/m/Y',strtotime($salary->payment_date))}}</td>
                                <td>{{$salary->amount}} DH</td>
                                <td>
                                    @can('update',$salary)
                                        <a href="{{url('salaries/'.$salary->id.'/edit')}}"><i
                                                    class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('delete',$salary)
                                        <a href="#" data-toggle="modal" onclick="pass_salary('{{$salary->id}}')"
                                           data-target=".bs-example-modal-salary"><i
                                                    class="fa fa-remove"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--modal for salaries--}}
                    <div class="modal fade bs-example-modal-salary" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel2">Confirmation</h4>
                                </div>
                                <div class="modal-body">
                                    <h4>Warning</h4>
                                    <h6><strong>Are you sure to delete that Salary?!</strong></h6>
                                </div>
                                <form id="delete_salary_form" method="post">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                        {{csrf_field()}}
                                        {{method_field('delete')}}
                                        <button type="submit" class="btn btn-danger">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- / end  salaries's modal -->
                </div>
                <div role="tabpanel" class="tab-pane fade @if($tab=='' or $tab=='exceptions') active in @endif" id="tab_content3" aria-labelledby="profile-tab">
                    @if(session()->has('success_exception'))
                        <center>
                            <div style="width: 70%;" class="alert alert-success ">
                                <b>{{session()->get('success_exception')}}</b>
                            </div>
                        </center>
                    @endif
                    @can('create',\App\Workexception::class)
                        <div class="pull-right">
                            <a href="{{url('exceptions/'.$employee->id)}}" class="btn btn-primary">Add a new work
                                exception</a>
                        </div>
                    @endcan
                    <table class="table table-hover" id="exceptions_table">
                        <thead>
                        <tr>
                            <th>Exception</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>Duration</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employee->workexceptions as $exception)
                            <tr>
                                <td>{{str_limit($exception->exception,60)}}</td>
                                <td>{{date('d/m/Y H:i',strtotime($exception->begin_date))}}</td>
                                <td>{{date('d/m/Y H:i',strtotime($exception->end_date))}}</td>
                                <td>{{\Carbon\Carbon::parse($exception->begin_date)->diffAsCarbonInterval($exception->end_date)}}
                                </td>
                                <td>
                                    @can('update',$exception)
                                        <a href="{{url('exceptions/'.$exception->id.'/edit')}}"><i
                                                    class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('delete',$exception)
                                        <a href="#" data-toggle="modal" onclick="pass_exception('{{$exception->id}}')"
                                           data-target=".bs-example-modal-exception"><i
                                                    class="fa fa-remove"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--modal for wor excption--}}
                    <div class="modal fade bs-example-modal-exception" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel2">Confirmation</h4>
                                </div>
                                <div class="modal-body">
                                    <h4>Warning</h4>
                                    <h6><strong>Are you sure to delete that Work exception?!</strong></h6>
                                </div>
                                <form id="delete_exception_form" method="post">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                        {{csrf_field()}}
                                        {{method_field('delete')}}
                                        <button type="submit" class="btn btn-danger">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- / end  work exception's modals -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script>
        function pass_exception(id_exception) {
            $('#delete_exception_form').attr('action', '{{url('exceptions')}}' + '/' + id_exception);
        }

        function pass_salary(id_salary) {
            $('#delete_salary_form').attr('action', '{{url('salaries')}}' + '/' + id_salary);
        }

        function pass_training(id_training) {
            $('#delete_training_form').attr('action', '{{url('trainings')}}' + '/' + id_training);
        }

        $(document).ready(function () {
            $('#salaries_table').DataTable();
            $('#exceptions_table').DataTable();
        });
    </script>
@stop