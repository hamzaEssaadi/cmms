@extends('layout.admin')


@section('title')Reports management @endsection
@section('x_title')
    <h2>Reports list</h2>
    <a href="{{route('reports.create')}}" class="btn btn-primary xs" style="float: right;">Add a new Report</a>
    <div class="clearfix"></div>
@endsection

@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            <b>{{session()->get('success')}}</b>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover" id="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Written by</th>
                <th>Sent to</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{$report->name}}</td>
                    <td>{{$report->description}}</td>
                    <td>
                        @if($report->from==0)
                            Director
                        @else
                            {{$report->from_employee->name}}
                        @endif
                    </td>
                    <td>
                        @if($report->to==0)
                            Director
                        @else
                            {{$report->to_employee->name}}
                        @endif
                    </td>
                    <td>
                        <a href="{{asset('uploads/reports/'.$report->path)}}"><i class="fa fa-download"></i></a>
                        @can('delete',$report)
                            <a style="margin-left: 10px;"
                               data-toggle="modal" data-target="#confirmation"
                               onclick="pass_id('{{$report->id}}')" href="#"><i class="fa fa-trash"></i></a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div id="confirmation" class="modal fade" role="dialog">
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
                    <h6><strong>Are you sure to remove that report ?!</strong></h6>
                </div>
                <form id="delete_report_form" method="post">
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
@stop

@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@stop
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script>
        function pass_id(id) {
            $('#delete_report_form').attr('action', '{{url('reports/')}}' + '/' + id);
        }

        $('#table').dataTable();
    </script>
@stop