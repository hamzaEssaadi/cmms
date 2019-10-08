@extends('layout.admin')
@section('title') Add a new Technical drawing @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('equipments')}}">Equipments management </a></li>
        <li><a href="{{route('technical-drawing',['equipment'=>$equipment->id])}}">Technical drawings</a></li>
        <li class="active"><strong>Add a new Technical drawing</strong></li>
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
                    {{session()->get('success')}}
                </div>
            @endif
            <form method="post" action="{{route('technical-drawing-store',['equipment'=>$equipment->id])}}" enctype="multipart/form-data">
                <div class="form-group  @if($errors->get('title')) has-error @endif ">
                    <label for="method">Title (*):</label>
                    <input class="form-control" type="text" name="title" value="{{old('title')}}"/>
                    @foreach($errors->get('title') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('type')) has-error @endif ">
                    <label for="method">Type (*):</label>
                    <input class="form-control" type="text" name="type" value="{{old('type')}}"/>
                    @foreach($errors->get('type') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('image')) has-error @endif ">
                    <label for="method">Image (*):</label>
                    <input type="file" onchange="readURL(this);" accept="image/*" name="image" value="{{old('image')}}"/>
                    @foreach($errors->get('image') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                    <img id="blah" class="img-thumbnail " width="" src="#" alt=""/>
                </div>
                <div class="form-group col-md-6">
                   <button type="submit" class="form-control btn btn-primary" >Save</button>
                </div>
                @csrf
                <div class="form-group col-md-6">
                   <a href="{{route('technical-drawing',['equipment'=>$equipment->id])}}" class="form-control btn btn-default" >Back</a>
                </div>

            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
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