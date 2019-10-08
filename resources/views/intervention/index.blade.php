@extends('layout.admin')


@section('title')Intervention Requests management @endsection
@section('x_title')
    <h2>Intervention list</h2>
    @can('create',\App\InterventionRequest::class)
        <a href="{{route('interventions-requests.create')}}" class="btn btn-primary xs" style="float: right;">Add a new
            Request</a>
    @endcan
    <div class="clearfix"></div>
@endsection
@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            <b>{{session()->get('success')}}</b>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover nowrap" id="table">
            <thead>
            <tr>
                <th>Code</th>
                <th>Status</th>
                <th>Written By</th>
                <th>Date</th>
                <th>Description</th>
                <th>Machine</th>
                <th>Cause</th>
                <th>W.O status</th>
                <th>Stopping hour</th>
                <th>Action</th>
                <th>Intervention start</th>
                <th>Intervention end</th>
                <th>Maintenance action</th>
            </tr>
            </thead>
            <tbody>
            {{--@foreach($interventions as $inter)--}}
            {{--<tr>--}}
            {{--<td>{{$inter->code}}</td>--}}
            {{--<td>--}}
            {{--<span class="@if($inter->status=='pending') label label-danger @elseif($inter->status=='requested') label label-warning--}}
            {{--@else label label-success @endif">{{$inter->status}}</span>--}}
            {{--</td>--}}
            {{--<td>--}}
            {{--@if($inter->employee_id==null)--}}
            {{--director--}}
            {{--@else--}}
            {{--{{$inter->employee->name}}--}}
            {{--@endif--}}
            {{--</td>--}}
            {{--<td><span class="hidden">{{$inter->date}}</span>{{date('d/m/Y',strtotime($inter->date))}}</td>--}}
            {{--<td>{{str_limit($inter->description,100)}}</td>--}}
            {{--<td>{{$inter->equipment->code}} </td>--}}
            {{--<td>{{$inter->disfunction->code}}</td>--}}
            {{--<td>{{str_limit($inter->action,100)}}</td>--}}
            {{--<td>--}}
            {{--@if($inter->workOrder!=null)--}}
            {{--@if($inter->workOrder->status=='pending')--}}
            {{--<span class="label label-warning">pending</span>--}}
            {{--@else--}}
            {{--<span class="label label-success">valid</span>--}}
            {{--@endif--}}
            {{--@else--}}
            {{--not yet--}}
            {{--@endif--}}
            {{--</td>--}}
            {{--<td>@if($inter->stopping_hour!=null)<span--}}
            {{--class="hidden">{{$inter->stopping_hour}}</span>{{date('d/m/Y H:i',strtotime($inter->stopping_hour))}}@endif--}}
            {{--</td>--}}
            {{--<td>@if($inter->start_hour!=null)<span--}}
            {{--class="hidden">{{$inter->start_hour}}</span>{{date('d/m/Y H:i',strtotime($inter->start_hour))}}@endif--}}
            {{--</td>--}}
            {{--<td>@if($inter->end_hour!=null)<span--}}
            {{--class="hidden">{{$inter->end_hour}}</span>{{date('d/m/Y H:i',strtotime($inter->end_hour))}}@endif--}}
            {{--</td>--}}
            {{--<td>--}}
            {{--@if($inter->workOrder==null)--}}
            {{--@can('createOrder',\App\InterventionRequest::class)--}}
            {{--<a href="{{route('request.order.create',['interventionRequest'=>$inter->id])}}"><i title="add work order"--}}
            {{--class="fa fa-plus"></i></a>--}}
            {{--@endcan--}}
            {{--@else--}}
            {{--<a href="{{route('request.show.order',['workOrder'=>$inter->workOrder->id])}}">--}}
            {{--<i class="fa fa-eye" title="show work order"></i>--}}
            {{--</a>--}}
            {{--@endif--}}
            {{--@can('validation',$inter)--}}
            {{--@if($inter->status=='pending' || $inter->status=='requested')--}}
            {{--<a href="{{route('request.validate',['interventionRequest'=>$inter->id])}}"><i--}}
            {{--class="fa fa-check" title="validation"></i></a>--}}
            {{--@else--}}
            {{--<a href="#" data-toggle="modal"--}}
            {{--onclick="pass_request('{{$inter->id}}')"--}}
            {{--data-target="#myModal"><i title="cancel validation" class="fa fa-undo"></i></a>--}}
            {{--@endif--}}
            {{--@endcan--}}
            {{--@can('update',$inter)--}}
            {{--<a href="{{route('interventions-requests.edit',['interventionRequest'=>$inter->id])}}">--}}
            {{--<i class="fa fa-edit" title="edit"></i></a>--}}
            {{--@endcan--}}
            {{--</td>--}}
            {{--</tr>--}}
            {{--@endforeach--}}
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
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
                    <h6><strong>Are you sure to cancel validation ?!</strong></h6>
                </div>
                <form id="delete_request_form" method="post">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                        </button>
                        {{csrf_field()}}
                        {{method_field('put')}}
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/datatable/responsive.bootstrap.min.css')}}" rel="stylesheet">

@stop
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.responsive.min.js')}}"></script>
    <script>
        function pass_request(id) {
            $('#delete_request_form').attr('action', '{{url('interventions-requests')}}' + '/' + id + '/cancel-validation');
        }

        $(document).ready(function () {
            $('#table').DataTable({
                responsive: true,
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 1},
                    {responsivePriority: 3, targets: 5},
                ],

                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('requests.ajax') }}",
                "columns": [
                    {"data": "code"},
                    {"data": "status", 'name': 'intervention_requests.status'},
                    {"data": "written_by", 'name': 'employees.name'},
                    {"data": "date", 'searchable': false},
                    {"data": "description"},
                    {"data": "machine", 'name': 'equipments.code'},
                    {"data": "cause", 'name': 'disfunctions.code'},
                    {"data": "work_order_status", 'orderable': false, 'searchable': false},
                    {"data": "stopping_hour", 'searchable': false},
                    {"data": "action_one", 'name': 'action_one', 'orderable': false, 'searchable': false},
                    {"data": "start_hour", 'searchable': false},
                    {"data": "end_hour", 'searchable': false},
                    {"data": "action"},

                ],
                "order": [[3, "desc"]]
            });
        });

    </script>
@stop