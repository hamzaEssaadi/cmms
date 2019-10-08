@extends('layout.admin')
@section('title')My tasks @endsection
@section('x_title')
    <h2>Tasks list</h2>
    <div class="clearfix"></div>
@endsection

@section('content')
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{session()->get('success')}}
    </div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover" id="table">
            <thead>
            <tr>
                <th>Description</th>
                <th>Duration</th>
                <th>Start date</th>
                <th>Project</th>
                <th>status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->task->text}}</td>
                    <td>{{$task->task->duration}} day(s)</td>
                    <td>{{date('d/m/Y',strtotime($task->task->start_date))}}</td>
                    <td>{{$task->task->task->text}}</td>
                    <td>
                        @if($task->status=='valid')
                            <span class="label label-success">{{$task->status}}</span>
                        @else
                            <span class="label label-warning">{{$task->status}}</span>
                        @endif
                    </td>
                    <td>
                        @if($task->status=='pending')
                            <a href="{{route('validation.myTask',['employee_task'=>$task->id])}}"><i class="fa fa-check" title="validation"></i></a>
                        @else
                            <a href="{{route('validation.myTask',['employee_task'=>$task->id])}}"><i class="fa fa-undo" title="undo validation"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop