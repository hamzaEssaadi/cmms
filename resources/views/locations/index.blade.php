@extends('layout.admin')
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@stop

@section('title')Location codes @endsection
@section('x_title')
    <h2>Locations list</h2>
    <a href="{{url('locations/create')}}" class="btn btn-primary xs" style="float: right;">Add a new Location</a>
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
            <th>Description</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($locations as $location)
            <tr>
                <td>{{$location->code}}</td>
                <td>{{$location->description}}</td>
                <td>
                    <a data-toggle="tooltip" data-original-title="Edit" href="{{url('locations/'.$location->id.'/edit')}}"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        } );
    </script>
@stop