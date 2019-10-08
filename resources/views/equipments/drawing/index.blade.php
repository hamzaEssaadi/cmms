@extends('layout.admin')
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@stop

@section('title') Technical drawing for the equipment {{$equipment->code}} @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{route('equipments.index')}}">Equipments management</a></li>
        <li class="active"><strong>Technical drawings</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>Technical drawings list</h2>
    <a href="{{route('technical-drawing-create',['equipment'=>$equipment->id])}}" class="btn btn-primary xs" style="float: right;">Add a new Technical
        drawing</a>
    <div class="clearfix"></div>
@endsection
@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            <b>{{session()->get('success')}}</b>
        </div>
    @endif
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($equipment->drawings as $drawing)
            <tr>
                <td>
                    <img class="img-thumbnail" style="width: 100px;height: 85px;" src="{{asset('drawings/equipments/'.$drawing->path)}}"/>
                </td>
                <td>{{$drawing->title}}</td>
                <td>{{$drawing->type}}</td>
                <td>
                    <a href="#"><i style="margin-left: 10px;"
                                   data-target=".bs-example-modal-drawing"
                                   data-toggle="modal"
                                   onclick="pass_drawing('{{$drawing->id}}')"
                                   class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{--modal for  drawing--}}
    <div class="modal fade bs-example-modal-drawing" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <h4>Warning</h4>
                    <h6><strong>Are you sure to delete that Technical drawing?!</strong></h6>
                </div>
                <form id="delete_drawing_form" method="post">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                        </button>
                        {{csrf_field()}}
                        {{method_field('delete')}}
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / end  drawing's modals -->
    <center>
        <a href="{{route('technical-drawing-show',['equipment'=>$equipment->id])}}" class="btn btn-info">Show album</a>
    </center>
@stop

@section('script')
<script>
    function pass_drawing(drawing_id) {
        $('#delete_drawing_form').attr('action','{{url('drawings/')}}'+'/'+drawing_id+'/delete');
    }
</script>
@stop
