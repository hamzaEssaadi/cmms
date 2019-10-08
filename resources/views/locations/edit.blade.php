@extends('layout.admin')
@section('title')Edit a Location @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('locations')}}">Location codes</a></li>
        <li class="active"><strong>Edit a Location</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    <form method="post" action="{{url('locations/'.$location->id)}}">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-group  @if($errors->get('code')) has-error @endif ">
                    <label for="code">Code :</label>
                    <input id="code" type="text" class="form-control" value="{{old('code',$location->code)}}"
                           name="code" required=""/>
                    @foreach($errors->get('code') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                {{csrf_field()}}
                {{method_field('PUT')}}
                <div class="form-group  @if($errors->get('description')) has-error @endif ">
                    <label for="description">Description :</label>
                    <input id="description" type="text" class="form-control"
                           value="{{old('description',$location->description)}}" name="description" required=""/>
                    @foreach($errors->get('description') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group">
                    <button class="btn btn-primary form-control" type="submit">Save</button>
                </div>
            </div>
        </div>
    </form>
@stop