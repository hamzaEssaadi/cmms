@extends('layout.admin')
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@stop
@section('title')Article's commands @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('articles')}}">Articles management </a></li>
        <li class="active"><strong>Command</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>{{$article->code}} Commands</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-3">
            <table class="table table-bordered">
                <thead>
                <tr>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><strong>Code</strong></td>
                    <td>{{$article->code}}</td>
                </tr>
                <tr>
                    <td><strong>Description</strong></td>
                    <td>{{$article->description}}</td>
                </tr>
                <tr>
                    <td><strong>Model</strong></td>
                    <td>{{$article->model}}</td>
                </tr>
                <tr>
                    <td><strong>Weight (kg)</strong></td>
                    <td>{{$article->weight}}</td>
                </tr>
                <tr>
                    <td><strong>Volume (cubic decimeter)</strong></td>
                    <td>{{$article->volume}}</td>
                </tr>
                <tr>
                    <td><strong>Added in</strong></td>
                    <td>
                        @if($article->added_in)
                            {{date('d/m/Y',strtotime($article->added_in))}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Manufacturer</strong></td>
                    <td>@if($article->manufacturer){{$article->manufacturer->code}}@endif</td>
                </tr>
                <tr>
                    <td><strong>Action</strong></td>
                    <td><a href="{{url('articles/'.$article->id.'/edit')}}" class="btn btn-success"><i
                                    class="fa fa-edit m-right-xs"></i> Edit Article</a>
                        <br/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-9">
            <div>
                <h2 class="pull-left">Commands list</h2>
                <a href="{{route('commands.create',['article'=>$article->id])}}" class="btn btn-primary pull-right">Add
                    new Command</a>
            </div>
            @if(session()->has('success'))
                <div class="alert alert-success clear">
                    <p>{{session()->get('success')}}</p>
                </div>
            @endif
            <div class="clear"></div>
            <div class="table-responsive">
                <table  class="table table-hover" id="table">
                    <thead>
                    <tr>
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
                    <tbody>
                    @foreach($article->commands as $command)
                        <tr>
                            <td>{{$command->employee->name}}</td>
                            <td>{{$command->stock->location->code}} ({{$command->stock->site}})</td>
                            <td>{{$command->qte_out}}</td>
                            <td>{{$command->cost}}</td>
                            <td><span class="hidden">{{$command->date}}</span> {{date('d/m/Y',strtotime($command->date))}}</td>
                            <td>{{str_limit($command->reason,15)}}</td>
                            <td>{{$command->location->code}}</td>
                            <td>
                                @if($command->status=='valid')
                                    <span class="label label-success">valid</span>
                                @else
                                    <span class="label label-info">pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="" onclick="pass_command('{{$command->id}}')" data-toggle="modal"
                                   data-target=".bs-example-modal-command">
                                    <i class="fa fa-remove"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{--modal for  command--}}
            <div class="modal fade bs-example-modal-command" tabindex="-1" role="dialog"
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
    </div>
@endsection
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            // $('#table').DataTable();
        });
    </script>
    <script>
        function pass_command(id) {
            $('#delete_command_form').attr('action', '{{url('articles')}}' + '/commands/' + id);
        }
    </script>
@stop