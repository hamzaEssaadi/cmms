@extends('layout.admin')
@section('title')Edit an Article @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('articles')}}">Articles management </a></li>
        <li class="active"><strong>Edit an Article</strong></li>
    </ol>
@endsection

@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    <form method="post" action="{{url('articles/'.$article->id)}}">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{session()->get('success')}}
                    </div>
                @endif
                <div class="form-group  @if($errors->get('code')) has-error @endif ">
                    <label for="code">Code (*):</label>
                    <input id="code" type="text" class="form-control" value="{{old('code',$article->code)}}" name="code"
                           required=""/>
                    @foreach($errors->get('code') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="form-group  @if($errors->get('description')) has-error @endif ">
                    <label for="code">Description (*):</label>
                    <textarea id="code" type="text" class="form-control" name="description"
                              required="">{{old('description',$article->description)}}</textarea>
                    @foreach($errors->get('description') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('weight')) has-error @endif ">
                    <label for="weight">Weight (kg) :</label>
                    <input id="weight" type="number" step="0.001" class="form-control"
                           value="{{old('weight',$article->weight)}}" name="weight"/>
                    @foreach($errors->get('weight') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('model')) has-error @endif ">
                    <label for="model">Model (*):</label>
                    <input id="model" type="text" class="form-control" value="{{old('model',$article->model)}}"
                           name="model" required=""/>
                    @foreach($errors->get('model') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('volume')) has-error @endif ">
                    <label for="volume">Volume (cubic decimeter) :</label>
                    <input id="volume" type="number" step="0.001" class="form-control"
                           value="{{old('volume',$article->volume)}}" name="volume"/>
                    @foreach($errors->get('volume') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('supply_point')) has-error @endif ">
                    <label for="supply_point">Supply point :</label>
                    <input id="supply_point" type="number" min="0"
                           class="form-control" value="{{old('supply_point',$article->supply_point)}}"
                           name="supply_point" required=""/>
                    @foreach($errors->get('supply_point') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('added_in')) has-error @endif ">
                    <label for="volume">Added in :</label>
                    <input id="added_in" type="text" class="form-control mydate" value="{{old('added_in',$article->added_in)}}"
                           name="added_in"/>
                    @foreach($errors->get('added_in') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>

                <div class="form-group ">
                    <label for="manufacturer">Manufacturer :</label>
                    <select id="manufacturer" class="form-control" name="manufacturer">
                        {{--<option value="">Select manufacturer</option>--}}
                        @foreach($manufacturers as $manufacturer)
                            <option @if($manufacturer->id==$article->manufacturer_id) selected=""
                                    @endif value="{{$manufacturer->id}}">{{$manufacturer->code}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary form-control" type="submit">Save</button>
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
        $('.mydate').datetimepicker({
            format: "YYYY/MM/DD",
        });
    </script>
@stop
