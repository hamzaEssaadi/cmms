@extends('layout.admin')
@section('title')Add a new Salary to {{$employee->name}} @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('employees')}}">Employees management </a></li>
        <li><a href="{{url('employees/'.$employee->id)}}">{{$employee->name}} </a></li>
        <li class="active"><strong>Add new Salary</strong></li>
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
            @if(session()->get('success'))
                <div class="alert alert-success">
                    <b>{{session()->get('success')}}</b>
                </div>
            @endif
            <form method="post" action="{{url('salaries/'.$employee->id)}}">
                <div class="form-group @if($errors->has('type')) has-error @endif">
                    <label for="type">Type :</label>
                    <input id="type" type="text" class="form-control" value="{{old('type')}}" name="type" required=""/>
                    @foreach($errors->get('type') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->has('start_date')) has-error @endif">
                    <label for="start_date">Period start :</label>
                    <input id="start_date" type="text" class="form-control" value="{{old('start_date')}}"
                           name="start_date" required=""/>
                    @foreach($errors->get('start_date') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->has('end_date')) has-error @endif">
                    <label for="end_date">Period end :</label>
                    <input id="end_date" type="text" class="form-control" value="{{old('end_date')}}" name="end_date"
                           required=""/>
                    @foreach($errors->get('end_date') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->has('payment_date')) has-error @endif">
                    <label for="payment_date">Date of payment :</label>
                    <input id="payment_date" type="text" class="form-control" value="{{old('payment_date')}}"
                           name="payment_date" required=""/>
                    @foreach($errors->get('payment_date') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->has('amount')) has-error @endif">
                    <label for="amount">Amount :</label>
                    <input id="amount" type="number" step="0.1" placeholder="DH" class="form-control" value="{{old('amount')}}"
                           name="amount" required=""/>
                    @foreach($errors->get('amount') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary form-control">Save</button>
                </div>
                <div class="form-group col-md-6">
                    <a href="{{url('employees/'.$employee->id)}}" class="btn btn-default form-control">Back</a>
                </div>
                {{csrf_field()}}
            </form>
        </div>
    </div>
@stop

@section('script')
    <script src="{{asset('template/date_picker/moment.min.js')}}"></script>
    <script src="{{asset('template/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('#start_date').datetimepicker(
            {
                format: 'YYYY/MM/DD HH:mm'
            }
        );
        $('#end_date').datetimepicker(
            {
                format: 'YYYY/MM/DD HH:mm'
            }
        );
        $('#payment_date').datetimepicker({
            format: 'YYYY/MM/DD'
        });
    </script>
@endsection