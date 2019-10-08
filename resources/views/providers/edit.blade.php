@extends('layout.admin')
@php
    $providerType= $provider->type=='supplier'?'Suppliers':'Manufacturers';
@endphp
@section('title')Add new {{str_replace('s','',$providerType)}} @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('providers/'.$provider->type)}}">{{$providerType}} management </a></li>
        <li class="active"><strong>Edit a {{str_replace('s','',$providerType)}}</strong></li>
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
            <form class="form-horizontal" method="post" action="{{url('providers/'.$provider->id)}}">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Code :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('code')) has-error @endif">
                        <input type="text" value="{{old('code',$provider->code)}}" name="code" class="form-control  ">
                        @foreach($errors->get('code') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Name :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12  @if($errors->get('name')) has-error @endif">
                        <input type="text" value="{{old('name',$provider->name)}}"  name="name" class="form-control ">
                        @foreach($errors->get('name') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Country :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 ">
                        <select class="form-control" name="country">
                            @foreach($countries as $country)
                                <option @if ($provider->country==$country->name) selected="" @endif value="{{$country->name}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                        @foreach($errors->get('country') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">City :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('city')) has-error @endif">
                        <input type="text" value="{{old('city',$provider->city)}}" name="city" class="form-control">
                        @foreach($errors->get('city') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Zip code :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('zip_code')) has-error @endif">
                        <input type="text" value="{{old('zip_code',$provider->zip_code)}}" name="zip_code" class="form-control">
                        @foreach($errors->get('zip_code') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('phone')) has-error @endif">
                        <input type="text" value="{{old('phone' ,$provider->phone)}}" name="phone" class="form-control">
                        @foreach($errors->get('phone') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Address :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('address')) has-error @endif">
                        <input type="text" value="{{old('address',$provider->address)}}" name="address" class="form-control">
                        @foreach($errors->get('address') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Fax :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('fax')) has-error @endif">
                        <input type="text" value="{{old('fax',$provider->fax)}}" name="fax" class="form-control">
                        @foreach($errors->get('fax') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Email :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('email')) has-error @endif">
                        <input type="text" value="{{old('email',$provider->email)}}" name="email" class="form-control">
                        @foreach($errors->get('email') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Web site :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('web_site')) has-error @endif">
                        <input type="text" value="{{old('web_site',$provider->web_site)}}" name="web_site" class="form-control">
                        @foreach($errors->get('web_site') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Director :</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 @if($errors->get('director')) has-error @endif">
                        <input type="text" value="{{old('director',$provider->director)}}" name="director" class="form-control">
                        @foreach($errors->get('director') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-primary form-control">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop