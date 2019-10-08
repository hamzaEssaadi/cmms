@extends('layout.admin')
@section('title')Edit an Intervention Preventive @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{route('preventive-interventions.index')}}">Intervention Preventive management </a></li>
        <li class="active"><strong>Edit an Intervention Preventive</strong></li>
    </ol>
@endsection

@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection

@section('content')
    <form method="post" action="{{route('preventive-interventions.update',['preventiveIntervention'=>$preventive->id])}}">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-xs-12">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        <b>{{session()->get('success')}}</b>
                    </div>
                @endif
                <div class="form-group  @if($errors->get('machine')) has-error @endif ">
                    <label for="machine">Machine :</label>
                    <select name="machine" id="machine" required="" class="form-control">
                        @foreach($machines as $machine)
                            <option @if($machine->id==$preventive->equipment_id) selected="" @endif value="{{$machine->id}}">{{$machine->code}}</option>
                        @endforeach
                    </select>
                    @foreach($errors->get('machine') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('description')) has-error @endif ">
                    <label for="description">Description :</label>
                    <textarea class="form-control" required="" name="description"
                              id="description">{{old('description',$preventive->description)}}</textarea>
                    @foreach($errors->get('description') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                {{--<div class="form-group  @if($errors->get('date')) has-error @endif ">--}}
                    {{--<label for="date">Date </label>--}}
                    {{--<input type="text" value="{{old('date',$preventive->date)}}" class="form-control"--}}
                           {{--id="date"--}}
                           {{--name="date" required=""/>--}}
                    {{--@foreach($errors->get('date') as $error)--}}
                        {{--<li style="color: red; margin-left: 12px;">{{$error}}</li>--}}
                    {{--@endforeach--}}
                {{--</div>--}}
                @csrf
                    @method('put')
                <div class="form-group  @if($errors->get('intervention_start')) has-error @endif ">
                    <label for="intervention_start">Intervention start :</label>
                    <input type="text" value="{{old('intervention_start',$preventive->intervention_start)}}" class="form-control"
                           id="intervention_start"
                           name="intervention_start" required=""/>
                    @foreach($errors->get('intervention_start') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('intervention_end')) has-error @endif ">
                    <label for="intervention_end">Intervention end :</label>
                    <input type="text" value="{{old('intervention_end',$preventive->intervention_end)}}" class="form-control"
                           id="intervention_end"
                           name="intervention_end" required=""/>
                    @foreach($errors->get('intervention_end') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group col-md-6 col-xs-6">
                    <button type="submit" class="form-control btn btn-primary">save</button>
                </div>
                <div class="form-group col-md-6 col-xs-6">
                    <a href="{{route('preventive-interventions.index')}}" class="form-control btn btn-default">back</a>
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
            width: 100% !important;
        }
    </style>
@stop
@section('script')
    <script src="{{asset('select2/select2.min.js')}}"></script>
    <script src="{{asset('template/date_picker/moment.min.js')}}"></script>
    <script src="{{asset('template/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('#intervention_end').datetimepicker(
            {
                format: 'YYYY/MM/DD HH:mm'
            }
        );
        $('#intervention_start').datetimepicker(
            {
                format: 'YYYY/MM/DD HH:mm'
            }
        );
        // $('#date').datetimepicker(
        //     {
        //         format: 'YYYY/MM/DD HH:mm'
        //     }
        // );
        $('#machine').select2({width: '100%'});
    </script>
@endsection