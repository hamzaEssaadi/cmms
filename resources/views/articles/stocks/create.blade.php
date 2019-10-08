@extends('layout.admin')
@section('title')Add a new Stock to {{$article->code}} @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('articles')}}">Article management</a></li>
        <li><a href="{{url('articles/'.$article->id)}}">{{$article->code}} </a></li>
        <li class="active"><strong>Add new Stock</strong></li>
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
            @if($locations->count()>0)
                <form method="post" action="{{url('stocks/'.$article->id)}}">
                    <div class="form-group @if($errors->has('site')) has-error @endif">
                        <label for="site">Site :</label>
                        <input id="site" type="text" class="form-control" value="{{old('site')}}" name="site"
                               required=""/>
                        @foreach($errors->get('site') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="location">Locations :</label>
                        <select name="location" class="form-control" id="location">
                            @foreach($locations as $location)
                                <option value="{{$location->id}}">{{$location->code}}</option>
                            @endforeach
                        </select>
                        @foreach($errors->get('location') as $error)
                            <li style="color: red; margin-left: 12px;">{{$error}}</li>
                        @endforeach
                    </div>
                    <div class="form-group @if($errors->has('qte')) has-error @endif">
                        <label for="qte">Quantity :</label>
                        <input id="qte" type="number" min="0" class="form-control" value="{{old('qte',1)}}" name="qte"
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
            @else
                <div class="alert alert-info">
                    <p>there is no available locations to add <b><a href="{{url('articles/'.$article->id)}}"><u>Back</u></a></b></p>

                </div>
            @endif
        </div>
    </div>
@stop
