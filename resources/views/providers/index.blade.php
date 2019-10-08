@extends('layout.admin')
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@stop
@php
    $provider= $type=='supplier'?'Suppliers':'Manufacturers';
@endphp
@section('title'){{$provider}} management @endsection
@section('x_title')

    <h2>{{$provider}} list</h2>
    <a href="{{url('providers/'.$type.'/create')}}" class="btn btn-primary xs" style="float: right;">Add
       a new {{str_replace('s','',$provider)}}</a>
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
            <th>Phone</th>
            <th>Fax</th>
            <th>Email</th>
            <th>WebSite</th>
            <th>Director</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($providers as $pro)
            <tr>
                <td>{{$pro->code}}</td>
                <td>{{$pro->name}}</td>
                <td>{{$pro->phone}}</td>
                <td>{{$pro->fax}}</td>
                <td>{{$pro->email}}</td>
                <td>{{$pro->web_site}}</td>
                <td>{{$pro->director}}</td>
                <td>
                 <a data-toggle="tooltip" data-original-title="Edit" href="{{url('providers/'.$pro->id.'/edit')}}"><i class="fa fa-edit"></i></a>
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
        $(document).ready(function () {
            $('#table').DataTable();
        });
    </script>
@stop