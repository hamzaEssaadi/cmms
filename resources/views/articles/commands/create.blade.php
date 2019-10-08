@extends('layout.admin')
@section('title')Add a new command @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('articles')}}">Articles management </a></li>
        <li><a href="{{route('commands',['article'=>$article->id])}}">Article commands</a></li>
        <li class="active"><strong>Add new Command</strong></li>
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
            <form method="post" action="{{route('commands.store',['article'=>$article->id])}}">
                @csrf
                <div class="form-group  @if($errors->get('delivered_to')) has-error @endif ">
                    <label for="delivered_to">Delivered to (*):</label>
                    <select name="delivered_to" id="delivered_to" class="form-control">
                        @foreach($employees as $emp)
                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                        @endforeach
                    </select>
                    @foreach($errors->get('delivered_to') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('delivered_from')) has-error @endif ">
                    <label for="delivered_from">Delivered from (*):</label>
                    <select name="delivered_from" id="delivered_from" class="form-control">
                        @foreach($article->stocks as $stock)
                            <option value="{{$stock->id}}">{{$stock->location->code}} ({{$stock->site}})</option>
                        @endforeach
                    </select>
                    @foreach($errors->get('delivered_from') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('actual_quantity')) has-error @endif ">
                    <label for="actual_quantity">Actual quantity (*):</label>
                   <input type="text" required="" readonly=""  id="actual_quantity" class="form-control" name="actual_quantity"/>
                    @foreach($errors->get('actual_quantity') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('quantity_released')) has-error @endif ">
                    <label for="quantity_released">Quantity released (*):</label>
                   <input type="number" required="" value="{{old('quantity_released')}}" min="1" id="quantity_released" class="form-control" name="quantity_released"/>
                    @foreach($errors->get('quantity_released') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('cost')) has-error @endif ">
                    <label for="cost">Adjusted unitary cost  (DH) (*):</label>
                   <input type="number" required="" value="{{old('cost')}}" step="0.01" id="cost" class="form-control" name="cost"/>
                    @foreach($errors->get('cost') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('date')) has-error @endif ">
                    <label for="date">Date (*):</label>
                   <input type="text"  required="" value="{{old('date')}}" id="date" class="form-control mydate" name="date"/>
                    @foreach($errors->get('date') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('reason')) has-error @endif ">
                    <label for="reason">Reason (*):</label>
                  <textarea name="reason" id="reason" required="" class="form-control">{{old('reason')}}</textarea>
                    @foreach($errors->get('reason') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group  @if($errors->get('location')) has-error @endif ">
                    <label for="location">To (*):</label>
                    <select name="location" id="location" required="" class="form-control">
                        @foreach($locations as $location)
                            <option value="{{$location->id}}">{{$location->code}}</option>
                        @endforeach
                    </select>
                    @foreach($errors->get('location') as $error)
                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                    @endforeach
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary form-control" >Save</button>
                </div>
                <div class="form-group col-md-6">
                   <a href="{{route('commands',['article'=>$article->id])}}" class="form-control btn btn-default">Back</a>
                </div>
            </form>
        </div>
        <div>
        </div>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/date_picker/css/bootstrap-datetimepicker.min.css')}}">
@stop
@section('script')
    <script src="{{asset('select2/select2.min.js')}}"></script>
    <script src="{{asset('template/date_picker/moment.min.js')}}"></script>
    <script src="{{asset('template/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.mydate').datetimepicker({
                format: "YYYY/MM/DD",
            });
            $('#delivered_to').select2();
            $('#delivered_from').select2();
            $('#location').select2();
            $('#delivered_from').trigger('change');
            $('#delivered_from').change(function () {
                var id =this.value;
                $.getJSON('{{url('articles')}}'+'/'+id+'/qte',function (result) {
                    $('#actual_quantity').val(result.qte);
                    $('#quantity_released').attr('max',result.qte);
                });
            });
            $('#delivered_from').change();
        });
    </script>
@stop