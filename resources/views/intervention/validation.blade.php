@extends('layout.admin')
@section('title')Validate Intervention Request @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{route('interventions-requests.index')}}">Intervention Requests management </a></li>
        <li class="active"><strong>Validate Intervention Request code  ({{$interventionRequest->code}})</strong></li>
    </ol>
@endsection

@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    <form method="post" action="{{route('request.validate.store',['interventionRequest'=>$interventionRequest->id])}}">
        <div class="row">
            @csrf
            <div class="col-md-6 col-md-offset-3 col-xs-12">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        <b>{{session()->get('success')}}</b>
                    </div>
                @endif
                <div class="form-group  @if($errors->get('action')) has-error @endif ">
                    <label for="action">Action :</label>
                    <textarea class="form-control" id="action" required="" name="action">{{old('action')}}</textarea>
                    @foreach($errors->get('action') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('start_hour')) has-error @endif ">
                    <label for="start_hour">Intervention start :</label>
                    <input type="text" class="form-control" required="" value="{{old('start_hour')}}" id="start_hour"
                           name="start_hour"/>
                    @foreach($errors->get('start_hour') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('end_hour')) has-error @endif ">
                    <label for="end_hour">Intervention end :</label>
                    <input type="text" class="form-control" required="" value="{{old('end_hour')}}" id="end_hour"
                           name="end_hour"/>
                    @foreach($errors->get('end_hour') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-xs-12">
                            <button type="submit" class="btn btn-primary form-control">validate</button>
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <a href="{{route('interventions-requests.index')}}" class="btn btn-default form-control">Back</a>
                        </div>
                    </div>
            </div>
        </div>
    </form>
@stop
@section('css')
    <link rel="stylesheet" href="{{asset('template/date_picker/css/bootstrap-datetimepicker.min.css')}}">
@stop
@section('script')
    <script src="{{asset('template/date_picker/moment.min.js')}}"></script>
    <script src="{{asset('template/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('#start_hour').datetimepicker(
            {
                format: 'YYYY/MM/DD HH:mm'
            }
        );
        $('#end_hour').datetimepicker(
            {
                format: 'YYYY/MM/DD HH:mm'
            }
        );
    </script>
@endsection