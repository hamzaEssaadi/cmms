@extends('layout.admin')
@section('title')Task details @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('/projects-details')}}">Project details </a></li>
        <li class="active"><strong>Details</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>{{str_limit($task->text,60)}} details</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    <div class="col-md-5">
        <table class="table table-bordered">
            <thead>
            <tr></tr>
            </thead>
            <tbody>
            <tr>
                <td><strong>Description</strong></td>
                <td>{{str_limit($task->text,60)}}</td>
            </tr>
            <tr>
                <td><strong>Start date</strong></td>
                <td>{{date('d/m/Y',strtotime($task->start_date))}}</td>
            </tr>
            <tr>
                <td><strong>Duration</strong></td>
                <td>{{$task->duration}} day(s)</td>
            </tr>
            <tr>
                <td><strong>Project</strong></td>
                <td>{{str_limit($task->task->text,60)}}</td>
            </tr>
        </table>
    </div>
    <div class="col-md-7">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"
                ><a href="#tab_content1" id="home-tab" role="tab"
                    data-toggle="tab" aria-expanded="true">Participants</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade  active in "
                     id="tab_content1" aria-labelledby="home-tab">
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{session()->get('success')}}</div>
                    @endif
                    <form class="form-horizontal"
                          action="{{route('add.participant',['task'=>$task->id])}}"
                          method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row"><label for="worker-select"
                                                    class="control-label col-md-3 col-sm-3 col-xs-12">Select</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <div class="input-group">
                                        <select style="width: 100%" id="employee-select"
                                                class="form-control"
                                                name="employee">
                                            @foreach($task->availableEmployees() as $employee)
                                                <option value="{{$employee->id}}">{{$employee->name}}
                                                    ({{$employee->job}})
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-btn">
                                              <button type="submit" style="margin-left: 10px" class="btn btn-primary">Add Participant</button>
                                          </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    @if($task->employees->count()>0)
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Job position</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($task->employees as $employee)
                                <tr>
                                    <td>{{$employee->employee->name}}</td>
                                    <td>{{$employee->employee->jobposition->code}}</td>
                                    <td>
                                        @if($employee->status=='pending')
                                            <span class="label label-warning"  style="background-color: #BCBEC0">{{$employee->status}}...</span>
                                        @else
                                            <span class="label label-success" style="width: 58px!important;display: inline-block">{{$employee->status}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span data-toggle="tooltip" data-original-title='detach'>
                                        <a href="#"
                                           class="fa fa-remove" onclick="pass_participant('{{$employee->id}}')" data-target=".bs-example-modal-participant" data-toggle="modal"></a>
                                          </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        {{--modal for  participant--}}
        <div class="modal fade bs-example-modal-participant" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                    aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Confirmation</h4>
                    </div>
                    <div class="modal-body">
                        <h4>Warning</h4>
                        <h6><strong>Are you sure to detach that participant ?!</strong></h6>
                    </div>
                    <form id="delete_participant_form" method="post">
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
        <!-- / end  participant's modals -->
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}">
@stop
@section('script')
    <script src="{{asset('select2/select2.min.js')}}"></script>
    <script>
        $('#employee-select').select2();
        function pass_participant(id) {
            $('#delete_participant_form').attr('action','{{url('/task-detach/')}}'+'/'+id);
        }
    </script>
@stop