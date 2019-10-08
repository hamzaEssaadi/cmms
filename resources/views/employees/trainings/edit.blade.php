@extends('layout.admin')
@section('title')Edit Training for {{$training->employee->name}} @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('employees')}}">Employees management </a></li>
        <li><a href="{{url('employees/'.$training->employee->id)}}">{{$training->employee->name}} </a></li>
        <li class="active"><strong>Edit Training</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    <b>{{session()->get('success')}}</b>
                </div>
            @endif
            <form method="post" action="{{url('trainings/'.$training->id)}}">
                {{method_field('PUT')}}
                {{csrf_field()}}
                <div class="form-group @if($errors->has('title')) has-error @endif">
                    <label for="title">Title :</label>
                    <input id="title" type="text" class="form-control" value="{{old('title',$training->title)}}"  name="title" required=""/>
                    @foreach($errors->get('title') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->has('description')) has-error  @endif">
                    <label for="description">Description :</label>
                    <textarea class="form-control" id="description"  required="" name="description">{{old('description',$training->description)}}</textarea>
                    @foreach($errors->get('description') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->has('date_start')) has-error @endif">
                    <label for="date_start">Date start :</label>
                    <input id="date_start" type="text" class="form-control mydate" value="{{old('date_start',$training->date_start)}}"  name="date_start" required=""/>
                    @foreach($errors->get('date_start') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->has('date_end')) has-error  @endif">
                    <label for="date_end">Date end :</label>
                    <input id="date_end" type="text" class="form-control mydate" value="{{old('date_end',$training->date_end)}}"  name="date_end" required=""/>
                    @foreach($errors->get('date_end') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->has('note')) has-error  @endif">
                    <label for="note">Note :</label>
                    <textarea class="form-control" id="note"  name="note">{{old('note',$training->note)}}</textarea>
                    @foreach($errors->get('note') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group col-md-6">
                    <button class="btn btn-primary form-control">Save</button>
                </div>
                <div class="form-group col-md-6">
                    <a href="{{url('employees/'.$training->employee->id)}}" class="btn btn-default form-control">Back</a>
                </div>
                {{csrf_field()}}
            </form>
        </div>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="{{asset('template/date_picker/css/bootstrap-datetimepicker.min.css')}}">
@stop
@section('script')
    <script src="{{asset('template/date_picker/moment.min.js')}}"></script>
    <script src="{{asset('template/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('.mydate').datetimepicker({
            format: "YYYY/MM/DD",
        });
    </script>
@stop