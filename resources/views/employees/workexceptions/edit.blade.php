@extends('layout.admin')
@section('title')Edit Work exception to {{$exception->employee->name}} @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('employees')}}">Employees management </a></li>
        <li><a href="{{url('employees/'.$exception->employee->id)}}">{{$exception->employee->name}} </a></li>
        <li class="active"><strong>Edit a Work exception</strong></li>
    </ol>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('template/date_picker/css/bootstrap-datetimepicker.min.css')}}">
@stop
@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if(session()->get('success_exception'))
                <div class="alert alert-success">
                    <b>{{session()->get('success_exception')}}</b>
                </div>
            @endif
            <form method="post" action="{{url('exceptions/'.$exception->id)}}">
                <div class="form-group @if($errors->has('exception')) has-error @endif">
                    <label for="exception">Exception :</label>
                    <input id="exception" type="text" class="form-control" value="{{old('exception',$exception->exception)}}" name="exception" required=""/>
                    @foreach($errors->get('exception') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->has('begin_date')) has-error @endif">
                    <label for="start_date">Start date :</label>
                    <input id="begin_date" type="text" class="form-control" value="{{old('begin_date',$exception->begin_date)}}"
                           name="begin_date" required=""/>
                    @foreach($errors->get('begin_date') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->has('end_date')) has-error @endif">
                    <label for="end_date">End date :</label>
                    <input id="end_date" type="text" class="form-control" value="{{old('end_date',$exception->end_date)}}" name="end_date"
                           required=""/>
                    @foreach($errors->get('end_date') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary form-control">Save</button>
                </div>
                <div class="form-group col-md-6">
                    <a href="{{url('employees/'.$exception->employee->id)}}" class="btn btn-default form-control">Back</a>
                </div>
                {{csrf_field()}}
                {{method_field('put')}}
            </form>
        </div>
    </div>
@stop

@section('script')
    <script src="{{asset('template/date_picker/moment.min.js')}}"></script>
    <script src="{{asset('template/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('#begin_date').datetimepicker(
            {
                format: 'YYYY/MM/DD HH:mm'
            }
        );
        $('#end_date').datetimepicker(
            {
                format: 'YYYY/MM/DD HH:mm'
            }
        );
    </script>
@endsection