@extends('layout.admin')
@section('title') Work orders types @endsection

@section('x_title')
    <h2>Work orders types list</h2>
    <a href="{{route('work-order-types.create')}}" class="btn btn-primary pull-right">Add a new Work order type</a>
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
            <table class="table table-hover" id="table">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($types as $type)
                    <tr>
                        <td>{{$type->code}}</td>
                        <td>{{$type->description}}</td>
                        <td>
                            <a href="{{route('work-order-types.edit',['WorkOrderType'=>$type->id])}}"><i title="edit" class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
@if($types->count()>10)
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@stop
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#table').DataTable();
        });
    </script>
@stop
@endif