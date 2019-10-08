@extends('layout.admin')
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@stop

@section('title')Job Position management @endsection
@section('x_title')
    <h2>Job positions list</h2>
    <a href="{{url('jobpositions/create')}}" class="btn btn-primary xs" style="float: right;">Add a new Job position</a>
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
            <th>Employees number</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($jobs as $job)
            <tr>
                <td>{{$job->code}}</td>
                <td>{{$job->description}}</td>
                <td>{{count($job->employees)}}</td>
                <td>
                    <a href="{{url('jobpositions/'.$job->id.'/edit')}}" ><i data-toggle="tooltip" data-original-title="edit" class="fa fa-edit"></i></a>
                    {{--<a href="#" style="margin-left:10px;"><i data-toggle="tooltip" data-original-title="remove" class="fa fa-remove"></i></a>--}}
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
            $('#table').DataTable(
                {{--{--}}
                    {{--"processing": true,--}}
                    {{--"serverSide": true,--}}
                    {{--"ajax": "{{ route('job.ajax') }}",--}}
                    {{--"columns": [--}}
                        {{--{"data":"code"},--}}
                        {{--{"data": "description"},--}}
                        {{--// {"data": "last_name"},--}}
                        {{--// {"data": "email"},--}}
                        {{--// {"data": "action",'name':'action','orderable':false,'searchable':false}--}}
                    {{--],--}}
                {{--}--}}
            );
        } );
    </script>
@stop