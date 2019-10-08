@extends('layout.admin')
@section('title')Add a new Work order @endsection
@section('css')
    <link rel="stylesheet" href="{{asset('template/switchery/switchery.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('template/date_picker/css/bootstrap-datetimepicker.min.css')}}">
@stop
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{route('interventions-requests.index')}}">Intervention Requests management</a></li>
        <li class="active"><strong>Add a new Work order</strong></li>
    </ol>
@endsection

@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            @if(session()->has('success'))
                <div class="alert alert-success clear">
                    <p>{{session()->get('success')}}</p>
                </div>
            @endif
            <form method="post" action="{{route('request.order.store',['interventionRequest'=>$interventionRequest->id])}}">
                <div class="form-group  @if($errors->get('code')) has-error @endif ">
                    <label for="code">Code :</label>
                    <input id="code" type="text" class="form-control" value="{{old('code')}}" name="code" required=""/>
                    @foreach($errors->get('code') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                {{csrf_field()}}
                <div class="form-group  @if($errors->get('description')) has-error @endif ">
                    <label for="code">Description :</label>
                    <textarea id="code" type="text" class="form-control" name="description"
                              required="">{{old('description')}}</textarea>
                    @foreach($errors->get('description') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('date')) has-error @endif ">
                    <label for="date">Demand date :</label>
                    <input id="date" type="text" class="form-control" value="{{old('date')}}" name="date" required=""/>
                    @foreach($errors->get('date') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="type">Type :</label>
                    <select id="type" name="type" class="form-control" required="">
                        @foreach($types as $type)
                            <option value="{{$type->id}}">{{$type->code}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="billable">Billable :</label>
                    <input id="billable" name="billable" type="checkbox" class="js-switch"/>
                </div>
                <div class="form-group">
                    <label for="cost">Estimated cost (DH) :</label>
                    <input id="cost" name="cost" value="{{old('cost')}}" type="number" step="0.01"  required="" class="form-control"/>
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary form-control">Save</button>
                </div>
                <div class="form-group col-md-6">
                    <a href="{{route('work-orders.index')}}" class="btn btn-default form-control">Back</a>
                </div>
            </form>
        </div>
    </div>
@stop
@section('script')
    <script src="{{asset('template/date_picker/moment.min.js')}}"></script>
    <script src="{{asset('template/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('template/switchery/switchery.min.js')}}"></script>
    <script>
        $('#date').datetimepicker({
            format: "YYYY/MM/DD",
        });
    </script>
@stop