@extends('layout.admin')
@section('title')Add a new Intervention Request @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{route('interventions-requests.index')}}">Intervention Requests management </a></li>
        <li class="active"><strong>Add a new Intervention Request </strong></li>
    </ol>
@endsection

@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection

@section('content')
    <form method="post" action="{{route('interventions-requests.store')}}">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-xs-12">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        <b>{{session()->get('success')}}</b>
                    </div>
                @endif
                <div class="form-group  @if($errors->get('code')) has-error @endif ">
                    <label for="code">Code :</label>
                    <input class="form-control" id="code" required="" value="{{old('code')}}" name="code"/>
                    @foreach($errors->get('code') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('date')) has-error @endif ">
                    <label for="date">Date :</label>
                    <input type="text" class="form-control" required="" value="{{old('date')}}" id="date" name="date"/>
                    @foreach($errors->get('date') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('description')) has-error @endif ">
                    <label for="description">Description :</label>
                    <textarea class="form-control" required="" name="description" id="description">{{old('description')}}</textarea>
                    @foreach($errors->get('description') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('machine')) has-error @endif ">
                    <label for="machine">Machine :</label>
                    <select name="machine" id="machine" required="" class="form-control">
                        @foreach($machines as $machine)
                            <option value="{{$machine->id}}">{{$machine->code}}</option>
                        @endforeach
                    </select>
                    @foreach($errors->get('machine') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                    <div class="form-group  @if($errors->get('cause')) has-error @endif ">
                    <label for="cause">Cause :</label>
                    <select name="cause" id="cause" required="" class="form-control select2">
                        @foreach($causes as $cause)
                            <option value="{{$cause->id}}">{{$cause->code}}</option>
                        @endforeach
                    </select>
                    @foreach($errors->get('machine') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                    @csrf
                <div class="form-group  @if($errors->get('stopping_hour')) has-error @endif ">
                    <label for="stopping_hour">Stopping hour :</label>
                    <input type="text" value="{{old('stopping_hour')}}" class="form-control" id="stopping_hour" name="stopping_hour" required=""/>
                    @foreach($errors->get('stopping_hour') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group col-md-6 col-xs-6">
                    <button type="submit" class="form-control btn btn-primary">save</button>
                </div>
                    <div class="form-group col-md-6 col-xs-6">
                    <a href="{{route('interventions-requests.index')}}" class="form-control btn btn-default">back</a>
                </div>
            </div>
        </div>
    </form>
@stop
@section('css')
    <link rel="stylesheet" href="{{asset('template/date_picker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}">
    <style>
        .select2 {
            width:100%!important;
        }
    </style>
@stop
@section('script')
    <script src="{{asset('select2/select2.min.js')}}"></script>
    <script src="{{asset('template/date_picker/moment.min.js')}}"></script>
    <script src="{{asset('template/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('#stopping_hour').datetimepicker(
            {
                format: 'YYYY/MM/DD HH:mm'
            }
        );
        $('#date').datetimepicker(
            {
                format: 'YYYY/MM/DD'
            }
        );
        $('#machine').select2({width:'100%'});
        $('#cause').select2();
    </script>
@endsection