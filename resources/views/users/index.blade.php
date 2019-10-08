@extends('layout.admin')
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@stop

@section('title')Users management @endsection
@section('x_title')
    <h2>Users list</h2>
    <a href="{{route('users.create')}}" class="btn btn-primary xs" style="float: right;">Add a new User account</a>
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
                <th>Email</th>
                <th>Job position</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->employee->jobposition->code}}</td>
                    <td>
                        @if($user->role=='rh_manager')
                            {{'hr manager'}}
                        @else
                            {{str_replace('_',' ',$user->role)}}
                        @endif
                    </td>
                    <td>
                        @can('update',$user)
                            <a href="{{route('users.edit',['user'=>$user->id])}}"><i data-toggle="tooltip"
                                                                                     data-original-title="Edit"
                                                                                     class="fa fa-edit"></i></a>
                        @endcan
                        @can('delete',$user)
                            <a data-toggle="tooltip" data-original-title="Remove" href="#"><i style="margin-left: 10px;"
                                                                                              data-target=".bs-example-modal-user"
                                                                                              data-toggle="modal"
                                                                                              onclick="pass_user('{{$user->id}}')"
                                                                                              class="fa fa-trash"></i></a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--modal for  user--}}
    <div class="modal fade bs-example-modal-user" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <h6><strong>Are you sure to delete that Payment?!</strong></h6>
                </div>
                <form id="delete_user_form" method="post">
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
    <!-- / end  user's modals -->
@stop
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script>
        function pass_user(id_user) {
            $('#delete_user_form').attr('action', '{{url('users')}}' + '/' + id_user);
        }

        $(document).ready(function () {
            $('#table').DataTable();
        });
    </script>
@stop