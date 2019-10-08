@extends('layout.admin')
@section('title')Add a new Report @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{route('reports.index')}}">Reports management</a></li>
        <li class="active"><strong>Add a new Report</strong></li>
    </ol>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}">
@stop
@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    <form method="post" action="{{route('reports.store')}}" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-xs-12">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        <b>{{session()->get('success')}}</b>
                    </div>
                @endif
                <div class="form-group @if($errors->get('to')) has-error @endif ">
                    <label for="to">To :</label>
                    <select id="to" class="form-control" name="to" required="">
                        <option value="0">Director</option>
                        @foreach($employees as $emp)
                            <option value="{{$emp->id}}">{{$emp->name}} ({{$emp->code}})</option>
                        @endforeach
                    </select>
                    @foreach($errors->get('to') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                @csrf
                <div class="form-group  @if($errors->get('name')) has-error @endif ">
                    <label for="name">Name :</label>
                    <input id="name" class="form-control" value="{{old('name')}}" name="name"/>
                    @foreach($errors->get('name') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('description')) has-error @endif ">
                    <label for="description">Description :</label>
                    <textarea id="description" class="form-control" name="description">{{old('description')}}</textarea>
                    @foreach($errors->get('description') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('file')) has-error @endif ">
                    <label for="file">File :</label>
                    <input required="" id="file" type="file" class="custom-file-input" name="file" accept="application/pdf,application/msword,
                    application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,
                    application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
                    @foreach($errors->get('file') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-primary form-control">Save</button>
                    </div>
                    <div class="form-group col-md-6">
                        <a class="btn btn-default form-control" href="{{route('reports.index')}}">Back</a>
                    </div>
                </div>

            </div>
        </div>
    </form>
@stop

@section('script')

    <script src="{{asset('select2/select2.min.js')}}"></script>
    <script>
        $('#to').select2();
    </script>
@stop