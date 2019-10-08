@extends('layout.admin')
@section('title')Add new Employee @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('employees')}}">Employees management </a></li>
        <li class="active"><strong>Edit an Employee</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    <form action="{{url('employees/'.$employee->id)}}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <div class="form-group  @if($errors->get('code')) has-error @endif ">
                    <label for="code">Code :</label>
                    <input id="code" type="text" class="form-control" value="{{old('code',$employee->code)}}"
                           name="code" required=""/>
                    @foreach($errors->get('code') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('name')) has-error @endif ">
                    <label for="name">Name :</label>
                    <input id="name" type="text" class="form-control" value="{{old('name',$employee->name)}}"
                           name="name" required=""/>
                    @foreach($errors->get('name') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('cin')) has-error @endif">
                    <label for="cin">CIN :</label>
                    <input id="cin" type="text" name="cin" value="{{old('cin',$employee->cin)}}"
                           class="form-control"/>
                    @foreach($errors->get('cin') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('birth_date')) has-error @endif">
                    <label for="birth_date">Date of birth :</label>
                    <input id="birth_date" type="text" name="birth_date"
                           value="{{old('birth_date',$employee->birth_date)}}"
                           class="form-control mydate"/>
                    @foreach($errors->get('birth_date') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('hiring_date')) has-error @endif">
                    <label for="hiring_date">Date of hiring :</label>
                    <input id="hiring_date" type="text" name="hiring_date"
                           value="{{old('hiring_date',$employee->hiring_date)}}"
                           class="form-control mydate"/>
                    @foreach($errors->get('hiring_date') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('nationality')) has-error @endif">
                    <label for="nationality">Nationality :</label>
                    <select class="form-control" id="nationality" name="nationality">
                        @foreach($countries as $country)
                            <option @if ($country->name==$employee->nationality) selected=""
                                    @endif value="{{$country->name}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                    @foreach($errors->get('nationality') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('image')) has-error @endif">
                    <label for="image">Change Image (<2mb): <i>(refresh the page to undo changes)</i></label>
                    <input type="file" onchange="readURL(this);" accept="image/*" value="{{old('image')}}"
                           class="custom-file" id="image" name="image">
                    @foreach($errors->get('image') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <img id="blah" class="img-thumbnail" width="300" src="{{asset('emplys/images/'.$employee->image)}}"
                     alt="your image"/>

            </div>
            <div class="col-md-6">
                <div class="form-group @if($errors->get('phone')) has-error @endif">
                    <label for="cin">Phone number :</label>
                    <input id="cin" type="text" name="phone" value="{{old('phone',$employee->phone)}}"
                           class="form-control"/>
                    @foreach($errors->get('phone') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('address')) has-error @endif">
                    <label for="address">Address :</label>
                    <input id="address" type="text" class="form-control" value="{{old('address',$employee->address)}}"
                           name="address"
                           required=""/>
                    @foreach($errors->get('address') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('zip_code')) has-error @endif">
                    <label for="zip_code">Zip code :</label>
                    <input id="zip_code" type="text" name="zip_code" value="{{old('zip_code',$employee->zip_code)}}"
                           class="form-control"
                           required=""/>
                    @foreach($errors->get('zip_code') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('email')) has-error @endif">
                    <label for="email">Email :</label>
                    <input id="email" type="text" name="email" value="{{old('email',$employee->email)}}" class="form-control"
                           />
                    @foreach($errors->get('email') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('social_security_no')) has-error @endif">
                    <label for="social_security_no">Social security number :</label>
                    <input type="text" required="" class="form-control"
                           value="{{old('social_security_no',$employee->social_security_no)}}"
                           id="social_security_no" name="social_security_no">
                    @foreach($errors->get('social_security_no') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('jobposition')) has-error @endif">
                    <label for="jobposition">Job position :</label>
                    <select class="form-control" id="jobposition" name="jobposition">
                        @foreach($jobpositions as $jobposition)
                            <option @if($jobposition->id==$employee->jobposition_id) selected="" @endif value="{{$jobposition->id}}">{{$jobposition->code}}</option>
                        @endforeach
                    </select>
                    @foreach($errors->get('nationality') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                    <button type="submit" style="margin-top: 1.5em;" class="btn btn-primary form-control">Save</button>
                </div>
            </div>
        </div>
    </form>
@stop
@section('css')
    <link rel="stylesheet" href="{{asset('template/date_picker/css/bootstrap-datetimepicker.min.css')}}">
@endsection
@section('script')
    <script src="{{asset('template/date_picker/moment.min.js')}}"></script>
    <script src="{{asset('template/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('.mydate').datetimepicker({
            format: "YYYY/MM/DD",
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                    // .width(150)
                    // .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@stop