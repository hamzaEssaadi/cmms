@extends('layout.admin')
@section('title')Edit an Intervention Request @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{route('interventions-requests.index')}}">Intervention Requests management </a></li>
        <li class="active"><strong>Edit an Intervention Request</strong></li>
    </ol>
@endsection

@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection
@php
    if(!session()->has('tab'))
    $tab='';
    else
    $tab=session()->get('tab');
@endphp
@section('content')
    <div class="" role="tabpanel" data-example-id="togglable-tabs">

        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="@if($tab=='' or $tab=='creating-info') active @endif"
            ><a href="#tab_content1" id="home-tab" role="tab"
                data-toggle="tab" aria-expanded="true">Construction Information</a>
            </li>
            @if($inter->status=='valid')
                <li role="presentation" class="@if($tab=='validation-info') active @endif"><a href="#tab_content2"
                                                                                              role="tab"
                                                                                              id="profile-tab"
                                                                                              data-toggle="tab"
                                                                                              aria-expanded="false">Validation
                        information</a>
                </li>
            @endif
        </ul>
        <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade @if($tab=='' or $tab=='creating-info') active in @endif"
                 id="tab_content1" aria-labelledby="home-tab">
                <form method="post" action="{{route('request.update.info',['interventionRequest'=>$inter->id])}}">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 col-xs-12">
                            @if(session()->get('success_info'))
                                <div class="alert alert-success">
                                    <b>{{session()->get('success_info')}}</b>
                                </div>
                            @endif
                            @method('put')
                            <div class="form-group  @if($errors->get('code')) has-error @endif ">
                                <label for="code">Code :</label>
                                <input class="form-control" id="code" required="" value="{{old('code',$inter->code)}}"
                                       name="code"/>
                                @foreach($errors->get('code') as $error)
                                    <li style="color: red; margin-left: 12px;">{{$error}}</li>
                                @endforeach
                            </div>
                            <div class="form-group  @if($errors->get('date')) has-error @endif ">
                                <label for="date">Date :</label>
                                <input type="text" class="form-control" required="" value="{{old('date',$inter->date)}}"
                                       id="date" name="date"/>
                                @foreach($errors->get('date') as $error)
                                    <li style="color: red; margin-left: 12px;">{{$error}}</li>
                                @endforeach
                            </div>
                            <div class="form-group  @if($errors->get('description')) has-error @endif ">
                                <label for="description">Description :</label>
                                <textarea class="form-control" required="" name="description"
                                          id="description">{{old('description',$inter->description)}}</textarea>
                                @foreach($errors->get('description') as $error)
                                    <li style="color: red; margin-left: 12px;">{{$error}}</li>
                                @endforeach
                            </div>
                            <div class="form-group  @if($errors->get('machine')) has-error @endif ">
                                <label for="machine">Machine :</label>
                                <select name="machine" id="machine" required="" class="form-control">
                                    @foreach($machines as $machine)
                                        <option @if($machine->id==$inter->equipment_id) selected=""
                                                @endif value="{{$machine->id}}">{{$machine->code}}</option>
                                    @endforeach
                                </select>
                                @foreach($errors->get('machine') as $error)
                                    <li style="color: red; margin-left: 12px;">{{$error}}</li>
                                @endforeach
                            </div>
                            <div class="form-group  @if($errors->get('cause')) has-error @endif ">
                                <label for="cause">Cause :</label>
                                <select name="cause" id="cause" required="" class="form-control">
                                    @foreach($causes as $cause)
                                        <option @if($cause->id==$inter->disfunction_id) selected=""
                                                @endif value="{{$cause->id}}">{{$cause->code}}</option>
                                    @endforeach
                                </select>
                                @foreach($errors->get('machine') as $error)
                                    <li style="color: red; margin-left: 12px;">{{$error}}</li>
                                @endforeach
                            </div>
                            @csrf
                            <div class="form-group  @if($errors->get('stopping_hour')) has-error @endif ">
                                <label for="stopping_hour">Stopping hour :</label>
                                <input type="text" value="{{old('stopping_hour',$inter->stopping_hour)}}"
                                       class="form-control" id="stopping_hour" name="stopping_hour" required=""/>
                                @foreach($errors->get('stopping_hour') as $error)
                                    <li style="color: red; margin-left: 12px;">{{$error}}</li>
                                @endforeach
                            </div>
                            <div class="form-group col-md-6 col-xs-6">
                                <button type="submit" class="form-control btn btn-primary">update</button>
                            </div>
                            <div class="form-group col-md-6 col-xs-6">
                                <a href="{{route('interventions-requests.index')}}"
                                   class="form-control btn btn-default">back</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @if($inter->status=='valid')
                <div role="tabpanel" class="tab-pane fade @if($tab=='validation-info') active in @endif"
                     id="tab_content2" aria-labelledby="home-tab">
                    <form method="post" action="{{route('request.update.validation',['interventionRequest'=>$inter->id])}}">
                        <div class="row">
                            @csrf
                            <div class="col-md-6 col-md-offset-3 col-xs-12">
                                @if(session()->get('success-validation'))
                                    <div class="alert alert-success">
                                        <b>{{session()->get('success-validation')}}</b>
                                    </div>
                                @endif
                                @method('put')
                                <div class="form-group  @if($errors->get('action')) has-error @endif ">
                                    <label for="action">Action :</label>
                                    <textarea class="form-control" id="action" required="" name="action">{{old('action',$inter->action)}}</textarea>
                                    @foreach($errors->get('action') as $error)
                                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                                    @endforeach
                                </div>
                                <div class="form-group  @if($errors->get('start_hour')) has-error @endif ">
                                    <label for="start_hour">Intervention start :</label>
                                    <input type="text" class="form-control" required="" value="{{old('start_hour',$inter->start_hour)}}" id="start_hour"
                                           name="start_hour"/>
                                    @foreach($errors->get('start_hour') as $error)
                                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                                    @endforeach
                                </div>
                                <div class="form-group  @if($errors->get('end_hour')) has-error @endif ">
                                    <label for="end_hour">Intervention end :</label>
                                    <input type="text" class="form-control" required="" value="{{old('end_hour',$inter->end_hour)}}" id="end_hour"
                                           name="end_hour"/>
                                    @foreach($errors->get('end_hour') as $error)
                                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-xs-12">
                                        <button type="submit" class="btn btn-primary form-control">update</button>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <a href="{{route('interventions-requests.index')}}" class="btn btn-default form-control">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>

    </div>
@stop
@section('css')
    <link rel="stylesheet" href="{{asset('template/date_picker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}">
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
        $('#machine').select2();
        $('#cause').select2();
    </script>
@endsection