@extends('layout.admin')
@section('css')
<link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@stop
@section('title')All commands @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li class="active"><strong>All Command</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>All Commands</h2>
    <div class="clearfix"></div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    <p>{{session()->get('success')}}</p>
                </div>
            @endif
                <table class="table table-hover" id="table">
                    <thead>
                    <tr>
                        <th>Article</th>
                        <th>Delivered to</th>
                        <th>Delivered from</th>
                        <th>Quantity released</th>
                        <th>Adjusted unitary cost (DH)</th>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>To</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    {{--<tbody>--}}
                    {{--@foreach($commands as $command)--}}
                        {{--<tr>--}}
                            {{--<td>{{$command->article->code}}</td>--}}
                            {{--<td>{{$command->employee->name}}</td>--}}
                            {{--<td>{{$command->stock->location->code}} ({{$command->stock->site}})</td>--}}
                            {{--<td>{{$command->qte_out}}</td>--}}
                            {{--<td>{{$command->cost}}</td>--}}
                            {{--<td>--}}
                                {{--<span class="hidden">{{$command->date}}</span>{{date('d/m/Y',strtotime($command->date))}}--}}
                            {{--</td>--}}
                            {{--<td>{{str_limit($command->reason,15)}}</td>--}}
                            {{--<td>{{$command->location->code}}</td>--}}
                            {{--<td>--}}
                                {{--@if($command->status=='valid')--}}
                                    {{--<span class="label label-success">valid</span>--}}
                                {{--@else--}}
                                    {{--<span class="label label-info">pending</span>--}}
                                {{--@endif--}}
                            {{--</td>--}}
                            {{--<td>--}}
                                {{--<a href="#" class="" onclick="pass_command('{{$command->id}}')" data-toggle="modal"--}}
                                   {{--data-target=".bs-example-modal-purposes">--}}
                                    {{--<i class="fa fa-remove"></i></a>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                    {{--</tbody>--}}
                </table>
            {{--{{$commands->links()}}--}}
        </div>
        {{--modal for  command--}}
        <div class="modal fade bs-example-modal-purposes" tabindex="-1" role="dialog"
             aria-hidden="true">
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
                        <h6><strong>Are you sure to Cancel this command ?!</strong></h6>
                    </div>
                    <form id="delete_command_form" method="post">
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
        <!-- / end  command's modals -->
    </div>
@stop

@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#table').DataTable(
                {
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('commands.ajax') }}",
                    "columns": [
                        {"data":"article",'name':'article.code'},
                        {"data":"delivered_to",'name':'employee.name'},
                        {"data":"delivered_from",'name':"stock.site"},
                        {"data":"qte_out",'searchable':false},
                        {"data":"cost",'searchable':false},
                        {"data":"date",'searchable':false},
                        {"data":"reason"},
                        {"data":"location",'name':'location.code'},
                        {"data":"status"},
                        {"data": "action",'name':'action','orderable':false,'searchable':false}
                    ],
                    "order": [[ 6, "asc" ]]
                }
            );
        });
    </script>
    <script>
        function pass_command(id) {
            $('#delete_command_form').attr('action', '{{url('articles')}}' + '/commands/' + id);
        }
    </script>
@stop