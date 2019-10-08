@extends('layout.admin')
@section('title') Add a new payment @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('equipments')}}">Equipments management </a></li>
        <li><a href="{{route('equipments.show',['equipment'=>$equipment->id])}}">Equipment details</a></li>
        <li class="active"><strong>Add a new payment </strong></li>
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
            <form method="post" action="{{route('payments.store',['equipment'=>$equipment->id])}}">
                @csrf
                <div class="form-group  @if($errors->get('method')) has-error @endif ">
                    <label for="method">Method (*):</label>
                   <input class="form-control" type="text" name="method" value="{{old('method')}}" id="method"/>
                    @foreach($errors->get('method') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('amount')) has-error @endif ">
                    <label for="amount">Amount (DH) (*):</label>
                   <input class="form-control" required="" type="number" step="0.01" name="amount" value="{{old('amount')}}" id="amount"/>
                    @foreach($errors->get('amount') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('date')) has-error @endif ">
                    <label for="date">Date (*):</label>
                   <input class="form-control" type="date" name="date" value="{{old('date')}}" id="date"/>
                    @foreach($errors->get('date') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary form-control">Save</button>
                </div>
                <div class="form-group col-md-6">
                    <a  href="{{route('equipments.show',['equipment'=>$equipment->id])}}" class="btn btn-default form-control">Back</a>
                </div>
            </form>
        </div>
    </div>
@stop