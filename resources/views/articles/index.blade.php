@extends('layout.admin')
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <style>
        .label{
        min-width: 75px !important;
           display: inline-block !important;
        }
    </style>
@stop

@section('title')Articles management @endsection
@section('x_title')
    <h2>Articles list</h2>
    <a href="{{url('articles/create')}}" class="btn btn-primary xs" style="float: right;">Add a new Article</a>
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
            <th>Weight (kg)</th>
            <th>Model</th>
            <th>Volume<br>(cubic decimeter)</th>
            <th>Added in</th>
            <th>Manufacturer</th>
            <th>Supply point</th>
            <th>Qte</th>
            <th>Error Type</th>
            <th>Action</th>
        </tr>
        </thead>
        {{--<tbody>--}}
        {{--@foreach($articles as $article)--}}
            {{--<tr>--}}
                {{--<td>{{$article->code}}</td>--}}
                {{--<td>{{str_limit($article->description,60)}}</td>--}}
                {{--<td>{{$article->weight}}</td>--}}
                {{--<td>{{$article->model}}</td>--}}
                {{--<td>{{$article->volume}}</td>--}}
                {{--<td>@if($article->added_in)<span class="hidden">{{$article->added_in}}</span>{{date('d/m/Y',strtotime($article->added_in))}}@endif</td>--}}
                {{--<td>@if($article->manufacturer_id!==null){{$article->manufacturer->code}}@endif</td>--}}
                {{--<td>--}}
                    {{--<div class="btn-group">--}}
                        {{--<button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-xs" type="button"--}}
                                {{--aria-expanded="false">Select action<span class="caret"></span>--}}
                        {{--</button>--}}
                        {{--<ul role="menu"  class="dropdown-menu">--}}
                            {{--<li><a href="{{url('articles/'.$article->id.'/edit')}}"><i class="fa fa-edit"> Edit</i></a>--}}
                            {{--</li>--}}
                            {{--<li><a href="{{url('articles/'.$article->id)}}"><i class="fa fa-eye"> Details</i></a>--}}
                            {{--</li>--}}
                            {{--<li><a href="{{route('commands',['article'=>$article->id])}}"><i class="fa fa-cubes"> Command list</i></a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</td>--}}
            {{--</tr>--}}
        {{--@endforeach--}}
        {{--</tbody>--}}
    </table>
@stop
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable(
                {
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('articles.ajax') }}",
                    "columns": [
                        {"data":"code"},
                        {"data": "description"},
                        {"data": "weight",'searchable':false},
                        {"data": "model"},
                        {"data": "volume",'searchable':false},
                        {"data": "added_in",'searchable':false},
                        {"data": "manufacturer",'name':'providers.code'},
                        {"data": "supply_point",'searchable':false},
                        {"data": "qte",'searchable':false,'orderable':false},
                        {"data": "error",'searchable':false,'orderable':false},
                        {"data": "action",'name':'action','orderable':false,'searchable':false}
                    ]
                }
            );
        } );
    </script>
@stop