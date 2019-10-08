@extends('layout.admin')
@section('title') Work orders management @endsection
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/datatable/responsive.bootstrap.min.css')}}" rel="stylesheet">

@stop
@section('x_title')
    <h2>Work orders list</h2>
    @can('create',\App\WorkOrder::class)
        <a href="{{route('work-orders.create')}}" class="btn btn-primary pull-right">Add a new Work order</a>
    @endcan
    <div class="clearfix"></div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('success'))
                <div class="alert alert-success clear">
                    <p>{{session()->get('success')}}</p>
                </div>
            @endif
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover" id="table">
            <thead>
            <tr>
                <th>Code</th>
                <th>Status</th>
                <th>Machine</th>
                <th>Demand date</th>
                <th>Type</th>
                <th>Description</th>
                <th>Billable</th>
                <th>Estimated cost (DH)</th>
                <th>Written by</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            {{--@foreach($orders as $order)--}}
            {{--<tr @if($order->status=='pending') class="bg bg-info" @endif>--}}
            {{--<td>{{$order->code}}</td>--}}
            {{--<td>{{$order->description}}</td>--}}
            {{--<td><span class="hidden">{{$order->demand_at}}</span>{{date('d/m/Y',strtotime($order->demand_at))}}--}}
            {{--</td>--}}
            {{--<td>{{$order->type->code}}</td>--}}
            {{--<td>{{$order->employee->name}}</td>--}}
            {{--<td>{{$order->billable==0?'no':'yes'}}</td>--}}
            {{--<td>{{$order->cost}}</td>--}}
            {{--<td>--}}
            {{--@if($order->status=='pending')--}}
            {{--<span class="label label-warning">pending</span>--}}
            {{--@else--}}
            {{--<span class="label label-success">valid</span>--}}
            {{--@endif--}}
            {{--</td>--}}
            {{--<td>--}}
            {{--@if($order->intervention_request_id!=null)--}}
            {{--{{$order->intervention->equipment->code}}--}}
            {{--@endif--}}
            {{--</td>--}}
            {{--<td>--}}
            {{--@can('validate',$order)--}}
            {{--@if($order->isValid(\Illuminate\Support\Facades\Auth::user()->employee_id)==0)--}}
            {{--<a href="{{route('validate.order',['worker'=>$order->getWorker()->id])}}"><i--}}
            {{--class="fa fa-check"></i></a>--}}
            {{--@else--}}
            {{--<a href="{{route('validate.order',['worker'=>$order->getWorker()->id])}}"><i--}}
            {{--class="fa fa-undo"></i></a>--}}
            {{--@endif--}}
            {{--@endcan--}}
            {{--<a href="{{route('work-orders.show',['workOrder'=>$order->id])}}"><i class="fa fa-eye"></i></a>--}}
            {{--<br>--}}
            {{--@can('update',$order)--}}
            {{--<a href="{{route('work-orders.edit',['workOrder'=>$order->id])}}"><i class="fa fa-edit"></i></a>--}}
            {{--@endcan--}}
            {{--@can('delete',$order)--}}
            {{--<a href="#"><i--}}
            {{--data-target=".bs-example-modal-delete"--}}
            {{--data-toggle="modal"--}}
            {{--onclick="pass_order('{{$order->id}}')"--}}
            {{--class="fa fa-trash"></i></a>--}}
            {{--@endcan--}}
            {{--</td>--}}
            {{--</tr>--}}
            {{--@endforeach--}}
            </tbody>
        </table>
    </div>
    {{--</div>--}}

    {{--modal for  delete--}}
    <div class="modal fade bs-example-modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <h6><strong>Are you sure to delete that work Order ?!</strong></h6>
                </div>
                <form id="delete_order_form" method="post">
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
    <!-- / end  delete's modals -->

@stop
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.responsive.min.js')}}"></script>

    <script>
        function pass_order(id) {
            $('#delete_order_form').attr('action', '{{url('work-orders')}}' + '/' + id);
        }

        $(document).ready(function () {
            $('#table').DataTable({
                responsive: true
                ,
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: -2},
                    {responsivePriority: 3, targets: -1},
                ],
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('orders.ajax') }}",
                "columns": [
                    {"data": "code",},
                    {"data": "status"},

                    {"data": "machine", 'name': 'equipments.code'},
                    {"data": "demand_at", 'searchable': false},
                    {"data": "type", 'name': 'work_order_types.code'},
                    {"data": "description",},
                    {"data": "billable"},
                    {"data": "cost", 'searchable': false},
                    {"data": "written_by", 'name': 'employees.name'},
                    {"data": "action", 'name': 'action', 'orderable': false, 'searchable': false}
                ]
            });
        });
    </script>
@stop