@extends('layout.admin')
@section('css')
    <link href="{{asset('gantt/dhtmlxgantt.css')}}" rel="stylesheet">
@stop

@section('title')Projects management @endsection
@section('x_title')
    <h2></h2>
@endsection
@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            <b>{{session()->get('success')}}</b>
        </div>
    @endif
    <div id="gantt_here" style='width:100%; height:900px;'></div>
@stop

@section('script')
    <script src="{{asset('gantt/dhtmlxgantt.js')}}?v=6.0.7"></script>
    <script>
        gantt.config.xml_date="%Y-%m-%d %H:%i:%s";
        gantt.config.order_branch = true;
        gantt.config.order_branch_free = true;
        gantt.init("gantt_here");
        gantt.load('{{url('api/data')}}');
        var dp=new gantt.dataProcessor("{{url('api/')}}");
        dp.init(gantt);
        dp.setTransactionMode("REST");
    </script>
@stop