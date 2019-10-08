@extends('layout.admin')
@section('title')Add a new Cost to {{$article->code}} @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('articles')}}">Article management</a></li>
        <li><a href="{{url('articles/'.$article->id)}}">{{$article->code}} </a></li>
        <li class="active"><strong>Add new Cost</strong></li>
    </ol>
@endsection
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
            <form method="post" action="{{url('articles/'.$article->id.'/cost')}}">
                <div class="form-group @if($errors->has('date')) has-error @endif">
                    <label for="date">Date :</label>
                    <input id="date" type="text" class="form-control mydate" value="{{old('date')}}" name="date" required=""/>
                    @foreach($errors->get('date') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->has('cost')) has-error @endif">
                    <label for="cost">Cost (DH):</label>
                    <input id="cost" type="number" step="0.01" class="form-control" value="{{old('cost')}}" name="cost" required=""/>
                    @foreach($errors->get('cost') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->has('qte')) has-error @endif">
                    <label for="qte">Quantity :</label>
                    <input id="qte" type="number" min="0" class="form-control" value="{{old('qte',0)}}" name="qte"
                           required=""/>
                    @foreach($errors->get('qte') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary form-control">Save</button>
                </div>
                <div class="form-group col-md-6">
                    <a href="{{url('articles/'.$article->id)}}" class="btn btn-default form-control">Back</a>
                </div>
                {{csrf_field()}}
            </form>
        </div>
    </div>
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
