@extends('layout.admin')
@section('title')Edit a  User Account for {{$user->name}} @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{route('users.index')}}">Users management</a></li>
        <li class="active"><strong>Edit a User Account</strong></li>
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
    <form method="post" action="{{route('users.update',['user'=>$user->id])}}">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        <b>{{session()->get('success')}}</b>
                    </div>
                @endif
                @csrf
                @method('PUT')
                <div class="form-group  @if($errors->get('role')) has-error @endif ">
                    <label for="role">Role :</label>
                    <select id="role" class="form-control" name="role" required="">
                        @if(\Illuminate\Support\Facades\Auth::user()->role=='super_admin')
                            <option @if($user->role=='rh_manager') selected="" @endif value="rh_manager">HR Manager
                            </option>
                        @endif
                        <option @if($user->role=='stock_manager') selected="" @endif value="stock_manager">Stock
                            Manager
                        </option>
                        <option @if($user->role=='maintenance_manager') selected="" @endif value="maintenance_manager">
                            Maintenance Manager
                        </option>
                        <option @if($user->role=='average_user') selected="" @endif  value="average_user">Average User
                        </option>
                        <option @if($user->role=='project_manager') selected="" @endif value="project_manager">Project
                            Manager
                        </option>
                    </select>
                    @foreach($errors->get('role') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="password">Change Password :</label>
                    <div class="input-group">
                        <input id="password" type="text" name="password" class="form-control">
                        <span class="input-group-btn">
                                              <button type="button" onclick="generate()"
                                                      class="btn btn-info">Generate !</button>
                                          </span>
                    </div>
                    @foreach($errors->get('password') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary form-control">Save</button>
                </div>
                <div class="form-group col-md-6">
                    <a class="btn btn-default form-control" href="{{route('users.index')}}">Back</a>
                </div>
            </div>
        </div>
    </form>
@stop

@section('script')
    {{--<script src="{{asset('template/switchery/switchery.min.js')}}"></script>--}}
    {{--<script src="{{asset('select2/select2.min.js')}}"></script>--}}
    <script>
        // $('#employee').select2();
        function generate() {
            var randomstring = Math.random().toString(36).slice(-10);
            $('#password').val(randomstring);
        }
    </script>
@stop