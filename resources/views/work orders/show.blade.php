@extends('layout.admin')
@section('title')Work order details @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{route('work-orders.index')}}">Work orders management </a></li>
        <li class="active"><strong>Details</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>{{$order->code}} details</h2>
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
        <div class="col-md-4 col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr></tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><strong>Code</strong></td>
                        <td>{{$order->code}}</td>
                    </tr>
                    <tr>
                        <td><strong>Description</strong></td>
                        <td>{{$order->description}}</td>
                    </tr>
                    <tr>
                        <td><strong>Demand date</strong></td>
                        <td>{{date('d/m/Y',strtotime($order->demand_at))}}</td>
                    </tr>
                    <tr>
                        <td><strong>Type</strong></td>
                        <td>{{$order->type->code}}</td>
                    </tr>
                    <tr>
                        <td><strong>Written by</strong></td>
                        <td>{{$order->employee->name}}</td>
                    </tr>
                    <tr>
                        <td><strong>Billable</strong></td>
                        <td>{{$order->billable==1?'yes':'no'}}</td>
                    </tr>
                    <tr>
                        <td><strong>Estimated cost (DH)</strong></td>
                        <td>{{$order->cost}}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>{{$order->status}}</td>
                    </tr>
                    @can('update',$order)
                        <tr>
                            <td><strong>Action</strong></td>
                            <td><a href="{{route('work-orders.edit',['workOrder'=>$order->id])}}"
                                   class="btn btn-success"><i
                                            class="fa fa-edit m-right-xs"></i> Edit Work order</a>
                                <br/>
                            </td>
                        </tr>
                    @endcan
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="@if($tab=='' or $tab=='workers') active @endif"
                    ><a href="#tab_content1" id="home-tab" role="tab"
                        data-toggle="tab" aria-expanded="true">Workers</a>
                    </li>
                    <li role="presentation" class="@if($tab=='equipments') active @endif"><a href="#tab_content2"
                                                                                             role="tab"
                                                                                             id="profile-tab"
                                                                                             data-toggle="tab"
                                                                                             aria-expanded="false">Equipments</a>
                    </li>
                    <li role="presentation" class="@if($tab=='articles') active @endif"><a href="#tab_content3"
                                                                                           role="tab"
                                                                                           id="profile-tab"
                                                                                           data-toggle="tab"
                                                                                           aria-expanded="false">Articles</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade @if($tab=='' or $tab=='workers') active in @endif"
                         id="tab_content1" aria-labelledby="home-tab">
                        @can('update',$order)
                            @if($workers->count()>0)
                                <div class="row">
                                    <form class="form-horizontal"
                                          action="{{route('add-worker',['workOrder'=>$order->id])}}"
                                          method="post">
                                        @csrf
                                        <div class="form-group">
                                            <div class="row"><label for="worker-select"
                                                                    class="control-label col-md-3 col-sm-3 col-xs-12">Select</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <div class="input-group">
                                                        <select style="width: 100%" id="worker-select"
                                                                class="form-control"
                                                                name="worker">
                                                            @foreach($workers as $worker)
                                                                <option value="{{$worker->id}}">{{$worker->name}}
                                                                    ({{$worker->code}}
                                                                    )
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="input-group-btn">
                                              <button type="submit" style="margin-left: 10px" class="btn btn-primary">Add worker</button>
                                          </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endcan
                        @if(session()->has('success_worker'))
                            <div class="alert alert-success">
                                {{session()->get('success_worker')}}
                            </div>
                        @endif
                        @if($order->workers->count()>0)
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Job position</th>
                                    <th>Status</th>
                                    @can('update',$order)
                                        <th>Action</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->workers as $worker)
                                    <tr>
                                        <td>{{$worker->employee->name}}</td>
                                        <td>{{$worker->employee->jobposition->code}}</td>
                                        <td>
                                            @if($worker->status=='pending')
                                                <span class="label label-warning" style="background-color: #BCBEC0;">pending...</span>
                                            @else
                                                <span class="label label-success">valid</span>
                                            @endif
                                        </td>
                                        @can('update',$order)
                                            <td>
                                                <a href="#"><i
                                                            data-target=".bs-example-modal-worker"
                                                            data-toggle="modal"
                                                            onclick="pass_worker('{{$worker->id}}')"
                                                            class="fa fa-remove"></i></a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div role="tabpanel" class="tab-pane fade @if($tab=='equipments') active in @endif"
                         id="tab_content2" aria-labelledby="home-tab">
                        @can('update',$order)
                            @if($equipments->count()>0)
                                <form class="form-horizontal"
                                      action="{{route('add-equipment',['workOrder'=>$order->id])}}"
                                      method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="equipment-select"
                                               class="control-label col-md-3 col-sm-3 col-xs-12">Select</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <div class="input-group">
                                                <select style="width: 100%" id="equipment-select" class="form-control"
                                                        name="equipment">
                                                    @foreach($equipments as $equipment)
                                                        <option value="{{$equipment->id}}">{{$equipment->code}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-btn">
                                              <button type="submit" style="margin-left: 10px" class="btn btn-primary">Add equipment</button>
                                          </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        @endcan
                        @if(session()->has('success_equipment'))
                            <div class="alert alert-success">
                                {{session()->get('success_equipment')}}
                            </div>
                        @endif
                        @if($order->equipments->count()>0)
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    @can('update',$order)
                                        <th>Action</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->equipments as $equipment)
                                    <tr>
                                        <td>{{$equipment->equipment->code}}</td>
                                        @can('update',$order)
                                            <td>
                                                <a href="#"><i
                                                            data-target=".bs-example-modal-equipment"
                                                            data-toggle="modal"
                                                            onclick="pass_equipment('{{$equipment->id}}')"
                                                            class="fa fa-remove"></i></a>

                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div role="tabpanel" class="tab-pane fade @if($tab=='articles') active in @endif"
                         id="tab_content3" aria-labelledby="home-tab">
                        @can('update',$order)
                            @if($articles->count()>0)
                                <form class="form-horizontal"
                                      action="{{route('add-article',['workOrder'=>$order->id])}}"
                                      method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="article-select"
                                               class="control-label col-md-3 col-sm-3 col-xs-12">Select</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <div class="input-group">
                                                <select style="width: 100%" id="article-select" class="form-control"
                                                        name="article">
                                                    @foreach($articles as $art)
                                                        <option value="{{$art->id}}">{{$art->code}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-btn">
                                              <button type="submit" style="margin-left: 10px" class="btn btn-primary">Add article</button>
                                          </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        @endcan
                        @if(session()->has('success_article'))
                            <div class="alert alert-success">
                                {{session()->get('success_article')}}
                            </div>
                        @endif
                        @if($order->articles->count()>0)
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    @can('update',$order)
                                        <th>Action</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->articles as $art)
                                    <tr>
                                        <td>{{$art->article->code}}</td>
                                        @can('update',$order)
                                            <td>
                                                <a href="#"><i
                                                            data-target=".bs-example-modal-article"
                                                            data-toggle="modal"
                                                            onclick="pass_article('{{$art->id}}')"
                                                            class="fa fa-remove"></i></a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--modal for  worker--}}
    <div class="modal fade bs-example-modal-worker" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <h6><strong>Are you sure to detach that worker ?!</strong></h6>
                </div>
                <form id="delete_worker_form" method="post">
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
    <!-- / end  worker's modals -->
    {{--modal for  equip--}}
    <div class="modal fade bs-example-modal-equipment" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <h6><strong>Are you sure to detach that equipment ?!</strong></h6>
                </div>
                <form id="delete_equipment_form" method="post">
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
    <!-- / end  equip's modals -->
    {{--modal for  equip--}}
    <div class="modal fade bs-example-modal-article" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <h6><strong>Are you sure to detach that article ?!</strong></h6>
                </div>
                <form id="delete_article_form" method="post">
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
    <!-- / end  equip's modals -->

@stop
@section('css')
    <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}">
@stop
@section('script')
    <script src="{{asset('select2/select2.min.js')}}"></script>
    <script>
        $('#worker-select').select2();
        $('#equipment-select').select2();
        $('#article-select').select2();

        function pass_worker(id_worker) {
            $('#delete_worker_form').attr('action', '{{url('detach-worker')}}' + '/' + id_worker);
        }

        function pass_equipment(id_equipment) {
            $('#delete_equipment_form').attr('action', '{{url('detach-equipment')}}' + '/' + id_equipment);
        }

        function pass_article($id_article) {
            $('#delete_article_form').attr('action', '{{url('detach-article')}}' + '/' + $id_article);
        }
    </script>
@stop