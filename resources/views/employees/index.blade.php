@extends('layout.admin')
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@stop

@section('title')Employees management @endsection
@section('x_title')
    <h2>Employees list</h2>
    <a href="{{url('employees/create')}}" class="btn btn-primary xs" style="float: right;">Add a new employee</a>
    <div class="clearfix"></div>
@endsection
@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            <b>{{session()->get('success')}}</b>
        </div>
    @endif
    <table id="table" class="table table-hover">
        <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Nationality</th>
            <th>Hiring date</th>
            <th>Address</th>
            <th>Social security no</th>
            <th>Job position</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($emps as $employee)
            <tr>
                <td>{{$employee->code}}</td>
                <td>{{$employee->name}}</td>
                <td>{{$employee->nationality}}</td>
                <td>
                    <span class="hidden">{{$employee->hiring_date}}</span>{{date('d/m/Y',strtotime($employee->hiring_date))}}
                </td>
                <td>{{$employee->address}}</td>
                <td>{{$employee->social_security_no}}</td>
                <td>{{$employee->jobposition->code}}</td>
                <td>
                    @can('update',$employee)
                        <a href="{{url('employees/'.$employee->id.'/edit')}}"><i data-toggle="tooltip"
                                                                                     data-original-title="Edit"
                                                                                     class="fa fa-edit"></i></a>
                    @endcan
                    <a href="{{url('employees/'.$employee->id)}}"><i data-toggle="tooltip" data-original-title="Details"
                                                                     class="fa fa-eye"></i></a>
                    @can('delete',$employee)
                        <a href="#" data-toggle="modal" data-target=".bs-example-modal-employee">
                            <i onclick="pass_employee('{{$employee->id}}')" class="fa fa-trash"></i>
                        </a>
                        @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="modal fade bs-example-modal-employee" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <h6><strong>Are you sure to delete that employee ?!</strong></h6>
                </div>
                <form id="delete_employee_form" method="post">
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
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script>
        function pass_employee(id)
        {
            $('#delete_employee_form').attr('action','{{url('employees')}}'+'/'+id)
        }
        $(document).ready(function () {
            $('#table').DataTable();
        });
    </script>
@stop