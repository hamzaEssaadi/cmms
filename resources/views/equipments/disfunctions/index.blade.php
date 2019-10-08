@extends('layout.admin')
@section('title') Dysfunction causes @endsection

@section('x_title')
    <h2>Dysfunctions causes list</h2>
    <a href="{{route('disfunctions.create')}}" class="btn btn-primary pull-right">Add new Dysfunction cause</a>
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
                @foreach($disfunctions as $disfunction)
                    <tr>
                        <td>{{$disfunction->code}}</td>
                        <td>{{$disfunction->description}}</td>
                        <td>
                                    <a data-toggle="tooltip" data-original-title="Edit"  href="{{route('disfunctions.edit',['disfunction'=>$disfunction->id])}}"><i
                                                    class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
@if($disfunctions->count()>10)
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