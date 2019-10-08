@extends('layout.admin')
@section('css')
    <link rel="stylesheet" href="{{asset('template/switchery/switchery.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/date_picker/css/bootstrap-datetimepicker.min.css')}}">
@stop
@section('title')Add a new Equipment @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{route('equipments.index')}}">Equipments management</a></li>
        <li class="active"><strong>Add a new Equipment</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    <strong>{{session()->get('success')}}</strong>
                </div>
            @endif
            <form class="form-horizontal" method="post" action="{{route('equipments.store')}}">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Code (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('code')) has-error @endif">
                        <input type="text" value="{{old('code')}}" required="" name="code" class="form-control  ">
                        @foreach($errors->get('code') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="serial_number" class="control-label col-md-3 col-sm-3 col-xs-12">Serial number (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('serial_number')) has-error @endif">
                        <input type="text" value="{{old('serial_number')}}" required="" name="serial_number"
                               id="serial_number" class="form-control  ">
                        @foreach($errors->get('serial_number') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="model_number" class="control-label col-md-3 col-sm-3 col-xs-12">Model number (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('model_number')) has-error @endif">
                        <input type="text" value="{{old('model_number')}}" required="" name="model_number"
                               id="model_number" class="form-control  ">
                        @foreach($errors->get('model_number') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12">Type (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('type')) has-error @endif">
                        <select name="type" id="type" class="form-control">
                            @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->code}}</option>
                            @endforeach
                        </select>
                        @foreach($errors->get('type') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="purchase_date" class="control-label col-md-3 col-sm-3 col-xs-12">Purchase date (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('purchase_date')) has-error @endif">
                        <input type="text" value="{{old('purchase_date')}}" required="" name="purchase_date"
                               id="purchase_date" class="form-control mydate">
                        @foreach($errors->get('purchase_date') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="warranty_expiration_date" class="control-label col-md-3 col-sm-3 col-xs-12">Warranty
                        expiration date (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('warranty_expiration_date')) has-error @endif">
                        <input type="text" value="{{old('warranty_expiration_date')}}" required=""
                               name="warranty_expiration_date" id="warranty_expiration_date" class="form-control mydate">
                        @foreach($errors->get('warranty_expiration_date') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="starting_date" class="control-label col-md-3 col-sm-3 col-xs-12">Starting date (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('starting_date')) has-error @endif">
                        <input type="text" value="{{old('starting_date')}}" required="" name="starting_date"
                               id="starting_date" class="form-control mydate">
                        @foreach($errors->get('starting_date') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="life_time" class="control-label col-md-3 col-sm-3 col-xs-12">Life time (years) (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('life_time')) has-error @endif">
                        <input type="number" step="0.25" value="{{old('life_time')}}" required="" name="life_time"
                               id="life_time" class="form-control">
                        @foreach($errors->get('life_time') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="location" class="control-label col-md-3 col-sm-3 col-xs-12">Location (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('security_note')) has-error @endif">
                        <select name="location" id="location" class="form-control">
                            @foreach($locations as $location)
                                <option value="{{$location->id}}">{{$location->code}}</option>
                            @endforeach
                        </select>
                        @foreach($errors->get('location') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="department" class="control-label col-md-3 col-sm-3 col-xs-12">Department (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('department')) has-error @endif">
                        <select name="department" id="department" class="form-control">
                            @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->code}}</option>
                            @endforeach
                        </select>
                        @foreach($errors->get('department') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="supplier" class="control-label col-md-3 col-sm-3 col-xs-12">Supplier (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('supplier')) has-error @endif">
                        <select name="supplier" id="supplier" class="form-control">
                            @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}">{{$supplier->code}}</option>
                            @endforeach
                        </select>
                        @foreach($errors->get('supplier') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="manufacturer" class="control-label col-md-3 col-sm-3 col-xs-12">Manufacturer (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('manufacturer')) has-error @endif">
                        <select name="manufacturer" id="manufacturer" class="form-control">
                            @foreach($manufacturers as $manufacturer)
                                <option value="{{$manufacturer->id}}">{{$manufacturer->code}}</option>
                            @endforeach
                        </select>
                        @foreach($errors->get('manufacturer') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="employee" class="control-label col-md-3 col-sm-3 col-xs-12">Responsible (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('employee')) has-error @endif">
                        <select name="employee" id="employee" class="form-control">
                            @foreach($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->name}} ({{$employee->jobposition->code}}
                                    )
                                </option>
                            @endforeach
                        </select>
                        @foreach($errors->get('employee') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="cost" class="control-label col-md-3 col-sm-3 col-xs-12">Cost (DH) (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('cost')) has-error @endif">
                        <input type="number" step="0.01" value="{{old('cost')}}" required="" name="cost"
                               id="life_time" class="form-control">
                        @foreach($errors->get('cost') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="security_note" class="control-label col-md-3 col-sm-3 col-xs-12">Security note (*):</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('security_note')) has-error @endif">
                        <textarea type="text" required="" name="security_note"
                                  id="security_note" class="form-control">{{old('security_note')}}</textarea>
                        @foreach($errors->get('security_note') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="in_service" class="control-label col-md-3 col-sm-3 col-xs-12">In service :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="checkbox" class="js-switch" name="in_service" id="in_service"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contract" class="control-label col-md-3 col-sm-3 col-xs-12">Contract :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" id="contract"
                               value="{{old('contract')}}" class="form-control"
                               name="contract"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-primary form-control">Save</button>
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
@stop

@section('script')
    <script src="{{asset('template/switchery/switchery.min.js')}}"></script>
    <script src="{{asset('select2/select2.min.js')}}"></script>
    <script src="{{asset('template/date_picker/moment.min.js')}}"></script>
    <script src="{{asset('template/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('.mydate').datetimepicker({
            format: "YYYY/MM/DD",
        });
        $('#location').select2();
        $('#department').select2();
        $('#type').select2();
        $('#supplier').select2();
        $('#manufacturer').select2();
        $('#employee').select2();

        // var elem = document.querySelector('#in_service');
        // var init = new Switchery(elem);

    </script>
@stop