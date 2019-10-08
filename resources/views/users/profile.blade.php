@extends('layout.admin')
@section('title')Update your profile @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li class="active"><strong>Update your profile</strong></li>
    </ol>
@endsection
@section('css')
    {{--<link rel="stylesheet" href="{{asset('template/switchery/switchery.min.css')}}"/>--}}
    {{--<link rel="stylesheet" href="{{asset('select2/select2.min.css')}}">--}}
@stop
@section('x_title')
    <h2>Fill in the fields</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    <form method="post" action="{{route('profile.update',['user'=>$user->id])}}">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        <b>{{session()->get('success')}}</b>
                    </div>
                @endif
                @csrf
                @method('PUT')
                <div class="form-group @if($errors->get('name')) has-error @endif ">
                    <label for="name">Name :</label>
                    <input id="name" value="{{old('name',$user->name)}}" name="name" class="form-control">
                    @foreach($errors->get('name') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('email')) has-error @endif ">
                    <label for="email">Email :</label>
                    <input id="email" value="{{old('email',$user->email)}}" name="email" class="form-control">
                    @foreach($errors->get('email') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('password')) has-error @endif ">
                    <label for="password">Password (leave it if you dont want to change the password):</label>
                    <input id="password" value="" name="password" class="form-control">
                    @foreach($errors->get('password') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group @if($errors->get('password_confirmation')) has-error @endif ">
                    <label for="password_confirmation ">Confirmation (leave it if you dont want to change the password):</label>
                    <input id="password_confirmation " value="" name="password_confirmation" class="form-control">
                    @foreach($errors->get('password_confirmation ') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-primary form-control">Save</button>
                    </div>
                    <div class="form-group col-md-6">
                        <a class="btn btn-default form-control" href="{{url('/')}}">Back</a>
                    </div>
            </div>
        </div>
    </form>
@endsection