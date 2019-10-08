@extends('layout.admin')
@section('title')Equipment details @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('equipments')}}">Equipments management </a></li>
        <li class="active"><strong>Details</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>{{$equipment->code}} details</h2>
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
        <div class="col-md-4">
            <table class="table table-bordered">
                <thead>
                <tr>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><strong>Code</strong></td>
                    <td>{{$equipment->code}}</td>
                </tr>
                <tr>
                    <td><strong>Serial number</strong></td>
                    <td>{{$equipment->serial_number}}</td>
                </tr>
                <tr>
                    <td><strong>Model number</strong></td>
                    <td>{{$equipment->model_number}}</td>
                </tr>
                <tr>
                    <td><strong>Type</strong></td>
                    <td>{{$equipment->equipment_type->code}}</td>
                </tr>
                <tr>
                    <td><strong>Purchase date</strong></td>
                    <td> {{date('d/m/Y',strtotime($equipment->purchase_date))}}</td>
                </tr>
                <tr>
                    <td><strong>Warranty expiration date</strong></td>
                    <td>{{date('d/m/Y',strtotime($equipment->warranty_expiration_date))}}</td>
                </tr>
                <tr>
                    <td><strong>Starting date</strong></td>
                    <td>{{date('d/m/Y',strtotime($equipment->starting_date))}}</td>
                </tr>
                <tr>
                    <td><strong>Life time (years)</strong></td>
                    <td>{{$equipment->life_time}}</td>
                </tr>
                <tr>
                    <td><strong>Location</strong></td>
                    <td>{{$equipment->location->code}}</td>
                </tr>
                <tr>
                    <td><strong>Department</strong></td>
                    <td>{{$equipment->department->code}}</td>
                </tr>
                <tr>
                    <td><strong>Supplier</strong></td>
                    <td>{{$equipment->supplier->code}}</td>
                </tr>
                <tr>
                    <td><strong>Manufacturer</strong></td>
                    <td>{{$equipment->manufacturer ->code}}</td>
                </tr>
                <tr>
                    <td><strong>Responsible</strong></td>
                    <td>{{$equipment->responsible->name}}</td>
                </tr>
                <tr>
                    <td><strong>Cost (DH)</strong></td>
                    <td>{{$equipment->cost}}</td>
                </tr>
                <tr>
                    <td><strong>Security note</strong></td>
                    <td>{{str_limit($equipment->security_note,60)}}</td>
                </tr>
                <tr>
                    <td><strong>In service</strong></td>
                    <td>{{$equipment->in_service==1?'yes':'no'}}</td>
                </tr>
                <tr>
                    <td><strong>Contract</strong></td>
                    <td>{{$equipment->contract}}</td>
                </tr>
                <tr>
                    <td><strong>Action</strong></td>
                    <td><a href="{{route('equipments.edit',['equipment'=>$equipment->id])}}" class="btn btn-success"><i
                                    class="fa fa-edit m-right-xs"></i> Edit Equipment</a>
                        <br/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-8">
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="@if($tab=='' or $tab=='spares') active @endif"
                    ><a href="#tab_content1" id="home-tab" role="tab"
                        data-toggle="tab" aria-expanded="true">Spare parts</a>
                    </li>
                    <li role="presentation" class="@if($tab=='payments') active @endif"><a href="#tab_content2"
                                                                                           role="tab"
                                                                                           id="profile-tab"
                                                                                           data-toggle="tab"
                                                                                           aria-expanded="false">Payments</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade @if($tab=='' or $tab=='spares') active in @endif"
                         id="tab_content1" aria-labelledby="home-tab">

                        <form class="form-horizontal" method="post"
                              action="{{route('spares.create',['equipment'=>$equipment->id])}}">
                            <div class="form-group">
                                <label for="article_select"
                                       class="control-label col-md-3 col-sm-3 col-xs-12">Select</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <div class="input-group">
                                        <select style="width: 100%" id="article_select" class="form-control"
                                                name="article">
                                            @foreach($articles as $article)
                                                <option value="{{$article->id}}">{{$article->code}}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-btn">
                                              <button type="submit" style="margin-left: 10px" class="btn btn-primary">Add Spare part</button>
                                          </span>
                                    </div>
                                </div>
                            </div>
                            @csrf
                        </form>
                        @if(session()->has('success_article'))
                            <div class="alert alert-success">
                                <p>{{session()->get('success_article')}}</p>
                            </div>
                        @endif
                        <table class="table table-hover" id="article_table">
                            <thead>
                            <tr>
                                <th>Spare part</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($equipment->spares as $spare)
                                <tr>
                                    <td>{{$spare->article->code}}</td>
                                    <td>
                                        <a href="#" data-toggle="modal" onclick="load_stocks('{{$spare->article->id}}')"
                                           data-target=".bs-example-modal-article-info"
                                           class="fa fa-eye"></a>
                                        <a href="#"><i style="margin-left: 10px;"
                                                       data-target=".bs-example-modal-spare"
                                                       data-toggle="modal"
                                                       onclick="pass_article('{{$spare->id}}')" class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{--modal for  article info--}}
                        <div class="modal fade bs-example-modal-article-info" tabindex="-1" role="dialog"
                             aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                    aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel2">Spare part details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Stocks list</h6>
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>Site</th>
                                                <th>Location</th>
                                                <th>Quantity</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbody-article">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / end  article info modals -->
                        {{--modal for  spare--}}
                        <div class="modal fade bs-example-modal-spare" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <h6><strong>Are you sure to delete that article?!</strong></h6>
                                    </div>
                                    <form id="delete_spare_form" method="post">
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
                        <!-- / end  spare's modals -->
                    </div>
                    <div role="tabpanel" class="tab-pane fade @if($tab=='payments') active in @endif" id="tab_content2"
                         aria-labelledby="profile-tab">
                        <a href="{{url('equipments/'.$equipment->id.'/payments/create')}}"
                           class="btn btn-primary pull-right">Add a new Payment</a>
                        @if(session()->has('success_payment'))
                            <div class="alert alert-success clear">
                                <p>{{session()->get('success_payment')}}</p>
                            </div>
                        @endif
                        @php
                            $total=0;
                        @endphp
                        @if($equipment->payments->count()>0)
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount (DH)</th>
                                    <th>Method</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($equipment->payments as $payment)
                                    <tr>
                                        <td>{{date('d/m/Y',strtotime($payment->date))}}</td>
                                        <td>{{$payment->amount}}</td>
                                        <td>{{$payment->method}}</td>
                                        <td>
                                            <a href="#"><i style="margin-left: 10px;"
                                                           data-target=".bs-example-modal-payment"
                                                           data-toggle="modal"
                                                           onclick="pass_payment('{{$payment->id}}')"
                                                           class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @php $total=$total+$payment->amount @endphp
                                @endforeach
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><strong>{{$total}} DH</strong></td>
                                    <td><strong>The Rest</strong></td>
                                    <td>
                                        <strong @if($equipment->rest()!=0) style="color: red;" @endif >{{$equipment->rest()}}
                                            (DH)</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        @endif
                        {{--modal for  spare--}}
                        <div class="modal fade bs-example-modal-payment" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <h6><strong>Are you sure to delete that Account ?!</strong></h6>
                                    </div>
                                    <form id="delete_payment_form" method="post">
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
                        <!-- / end  spare's modals -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}">
@stop
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('select2/select2.min.js')}}"></script>
    <script>
        $('#article_select').select2();

        function pass_article(spare_id) {
            $('#delete_spare_form').attr('action', '{{url('spares')}}' + '/' + spare_id + '/delete');
        }

        function pass_payment(payment_id) {
            $('#delete_payment_form').attr('action', '{{url('payments')}}' + '/' + payment_id);
        }

        function load_stocks(id_article) {
            $.getJSON('{{url('stocks/article')}}' + '/' + id_article, function (result) {
                $('#tbody-article').empty();
                stocks = result.data;
                for (var i = 0; i < stocks.length; i++) {
                    var stock = stocks[i];
                    $('#tbody-article').append('<tr>' +
                        '<td>' + stock.site + '</td>' +
                        '' + '<td>' + stock.location + '</td>' +
                        '<td>' + stock.qte + '</td>' +
                        '</tr>');
                }
            })
        }
    </script>
@stop