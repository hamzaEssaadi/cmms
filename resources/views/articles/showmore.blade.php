@extends('layout.admin')
@section('title')Article details @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('articles')}}">Articles management </a></li>
        <li class="active"><strong>More Details</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>{{$article->code}} details</h2>
    <div class="clearfix"></div>
@endsection

@section('content')
    @php
        if(!session()->has('tab'))
        $tab='';
        else
        $tab=session()->get('tab');
    @endphp
    <div class="row">
        {{--<h1 style="color: red;">ici {{$tab}}</h1>--}}
        <div class="col-md-4">
            <table class="table table-bordered">
                <thead>
                <tr>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><strong>Code</strong></td>
                    <td>{{$article->code}}</td>
                </tr>
                <tr>
                    <td><strong>Description</strong></td>
                    <td>{{$article->description}}</td>
                </tr>
                <tr>
                    <td><strong>Model</strong></td>
                    <td>{{$article->model}}</td>
                </tr>
                <tr>
                    <td><strong>Weight (kg)</strong></td>
                    <td>{{$article->weight}}</td>
                </tr>
                <tr>
                    <td><strong>Volume (cubic decimeter)</strong></td>
                    <td>{{$article->volume}}</td>
                </tr>
                <tr>
                    <td><strong>Added in</strong></td>
                    <td>
                        @if($article->added_in)
                            {{date('d/m/Y',strtotime($article->added_in))}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Manufacturer</strong></td>
                    <td>@if($article->manufacturer){{$article->manufacturer->code}}@endif</td>
                </tr>
                <tr>
                    <td><strong>Action</strong></td>
                    <td><a href="{{url('articles/'.$article->id.'/edit')}}" class="btn btn-success"><i
                                    class="fa fa-edit m-right-xs"></i> Edit Article</a>
                        <br/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-8">
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="@if($tab=='' or $tab=='costs') active @endif"
                    ><a href="#tab_content3" id="home-tab" role="tab"
                        data-toggle="tab" aria-expanded="true">Costs</a>
                    </li>
                    <li role="presentation" class="@if($tab=='purposes') active @endif"><a href="#tab_content4"
                                                                                           role="tab" id="profile-tab"
                                                                                           data-toggle="tab"
                                                                                           aria-expanded="false">Purposes</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade @if($tab=='' or $tab=='costs') active in @endif"
                         id="tab_content3" aria-labelledby="home-tab">
                        @if(session()->has('success_cost'))
                            <div class="alert alert-success">
                                <p>{{session()->get('success_cost')}}</p>
                            </div>
                        @endif
                        <div class="pull-right">
                            <a href="{{url('articles/'.$article->id.'/cost')}}" class="btn btn-primary">Add a new
                                Cost</a>
                        </div>
                        @if($article->costs->count()>0)
                            <table class="table table-hover" id="suppliers_table">
                                <thead>
                                <tr>
                                    <th>Cost (DH)</th>
                                    <th>Date</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($article->costs as $cost)
                                    <tr>
                                        <td>{{$cost->cost}}</td>
                                        <td>{{date('d/m/Y',strtotime($cost->date))}}</td>
                                        <td>{{$cost->qte}}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" onclick="pass_cost('{{$cost->id}}')"
                                               data-target=".bs-example-modal-cost"><i
                                                        class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                        {{--modal for  cost--}}
                        <div class="modal fade bs-example-modal-cost" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <h6><strong>Are you sure to delete that cost ?!</strong></h6>
                                    </div>
                                    <form id="delete_cost_form" method="post">
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
                        <!-- / end  cost's modals -->
                    </div>
                    <div role="tabpanel" class="tab-pane fade @if($tab=='purposes') active in @endif" id="tab_content4"
                         aria-labelledby="profile-tab">
                        @if(session()->has('success_purposes'))
                            <div class="alert alert-success">
                                <p>{{session()->get('success_purposes')}}</p>
                            </div>
                        @endif
                        <form class="form-horizontal" method="post"
                              action="{{url('articles/'.$article->id.'/purposes')}}">
                            <div class="form-group">
                                @csrf
                                <label for="usage" class="control-label col-md-3 col-sm-3 col-xs-12">Usage note
                                    :</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <div class="input-group @if($errors->has('usage')) has-error @endif">
                                        <input type="text" required="" id="usage" class="form-control" name="usage"/>
                                        <span class="input-group-btn">
                                              <button type="submit" class="btn btn-primary">Add</button>
                                          </span>
                                    </div>
                                    @foreach($errors->get('usage') as $error)
                                        <li style="color: red; margin-left: 12px;">{{$error}}</li>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                        <ul class="list-group">
                            @foreach($article->purposes as $purpose)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$purpose->usage_note}}
                                    <span class="">
                                                  <a href="#" data-toggle="modal" onclick="pass_purpose('{{$purpose->id}}')"
                                                     data-target=".bs-example-modal-purposes"><i
                                                              class="fa fa-trash pull-right"></i></a>
                                    </span>
                                </li>
                            @endforeach
                                {{--modal for  cost--}}
                                <div class="modal fade bs-example-modal-purposes" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <h6><strong>Are you sure to delete that usage purpose ?!</strong></h6>
                                            </div>
                                            <form id="delete_purposes_form" method="post">
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
                                <!-- / end  cost's modals -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        function pass_cost(id_cost) {
            $('#delete_cost_form').attr('action', '{{url('articles')}}' + '/' + id_cost + '/delete');
        }
        function pass_purpose(id_purposes) {
            $('#delete_purposes_form').attr('action', '{{url('articles')}}' + '/' + id_purposes + '/delete/purpose');
        }
    </script>
@stop

