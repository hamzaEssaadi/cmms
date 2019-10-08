@extends('layout.admin')
@section('title')Add new Job position @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('jobpositions')}}">Job position management </a></li>
        <li class="active"><strong>Add a new Job position</strong></li>
    </ol>
@endsection

@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    <form method="post" action="{{url('jobpositions')}}">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if(session()->has('success'))
                <div class="alert alert-success">
                    <p>{{session()->get('success')}}</p>
                </div>
                @endif
                <div class="form-group  @if($errors->get('code')) has-error @endif ">
                    <label for="code">Code :</label>
                    <input id="code" type="text" class="form-control" value="{{old('code')}}" name="code" required=""/>
                    @foreach($errors->get('code') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                {{csrf_field()}}
                <div class="form-group  @if($errors->get('description')) has-error @endif ">
                    <label for="code">Description :</label>
                    <input id="code" type="text" class="form-control" value="{{old('description')}}" name="description" required=""/>
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
