@extends('layout.admin')
@section('title')Article details @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{url('articles')}}">Articles management </a></li>
        <li class="active"><strong>Details</strong></li>
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
            <h1>{{session()->get('name')}}</h1>
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="@if($tab=='' or $tab=='suppliers') active @endif"
                    ><a href="#tab_content1" id="home-tab" role="tab"
                        data-toggle="tab" aria-expanded="true">Suppliers</a>
                    </li>
                    <li role="presentation" class="@if($tab=='stocks') active @endif"><a href="#tab_content2" role="tab"
                                                                                         id="profile-tab"
                                                                                         data-toggle="tab"
                                                                                         aria-expanded="false">Stocks</a>
                    </li>
                    <li role="presentation" class="@if($tab=='replacements') active @endif"><a href="#tab_content3"
                                                                                               role="tab"
                                                                                               id="profile-tab2"
                                                                                               data-toggle="tab"
                                                                                               aria-expanded="false">Replacements</a>
                    </li>
                    <li role="presentation" class="@if($tab=='costs') active @endif"
                    ><a href="#tab_content4" id="home-tab" role="tab"
                        data-toggle="tab" aria-expanded="true">Costs</a>
                    </li>
                    <li role="presentation" class="@if($tab=='purposes') active @endif"><a href="#tab_content5"
                                                                                           role="tab" id="profile-tab"
                                                                                           data-toggle="tab"
                                                                                           aria-expanded="false">Notes</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade @if($tab=='' or $tab=='suppliers') active in @endif"
                         id="tab_content1" aria-labelledby="home-tab">
                        @if($suppliers->count()>0)
                            <form class="form-horizontal" method="post"
                                  action="{{url('articles/'.$article->id.'/suppliers')}}">
                                @csrf
                                <div class="form-group">
                                    <label for="supplier"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Select</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <div class="input-group">
                                            <select id="supplier" class="form-control" name="supplier">
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}">{{$supplier->code}}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-btn">
                                              <button type="submit" class="btn btn-primary">Add supplier</button>
                                          </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                        @if(session()->has('success_supplier'))
                            <div class="alert alert-success">
                                <p>{{session()->get('success_supplier')}}</p>
                            </div>
                        @endif
                        <table class="table table-hover" id="suppliers_table">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($article->suppliers as $supplier)
                                <tr>
                                    <td>{{$supplier->supplier->code}}</td>
                                    <td>{{$supplier->supplier->name}}</td>
                                    <td>{{$supplier->supplier->phone}}</td>
                                    <td>
                                        <a href="#" data-toggle="modal"
                                           onclick="pass_supplier_details('{{$supplier->supplier->code}}','{{$supplier->supplier->name}}','{{$supplier->supplier->country}}',
                                                   '{{$supplier->supplier->city}}','{{$supplier->supplier->zip_code}}','{{$supplier->supplier->phone}}',
                                                   '{{$supplier->supplier->address}}','{{$supplier->supplier->fax}}','{{$supplier->supplier->email}}','{{$supplier->supplier->web_site}}',
                                                   '{{$supplier->supplier->director}}')"
                                           data-target=".bs-example-modal-supplier-details"><i
                                                    class="fa fa-eye"></i></a>
                                        <a href="#" style="margin-left: 10px;" data-toggle="modal"
                                           onclick="pass_supplier('{{$supplier->id}}')"
                                           data-target=".bs-example-modal-supplier"><i
                                                    class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{--modal for  supplier--}}
                        <div class="modal fade bs-example-modal-supplier" tabindex="-1" role="dialog"
                             aria-hidden="true">
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
                                        <h6><strong>Are you sure to delete that Supplier?!</strong></h6>
                                    </div>
                                    <form id="delete_supplier_form" method="post">
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
                        <!-- / end  supplier's modals -->
                        {{--modal for  supplier details--}}
                        <div class="modal fade bs-example-modal-supplier-details" tabindex="-1" role="dialog"
                             aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                    aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel2">Details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><strong>Code</strong></td>
                                                <td id="supplier-code"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Name</strong></td>
                                                <td id="supplier-name"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Country</strong></td>
                                                <td id="supplier-country"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>City</strong></td>
                                                <td id="supplier-city"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Zip code</strong></td>
                                                <td id="supplier-zip_code"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Phone</strong></td>
                                                <td id="supplier-phone"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Address</strong></td>
                                                <td id="supplier-address"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Fax</strong></td>
                                                <td id="supplier-fax"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email</strong></td>
                                                <td id="supplier-email"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Web site</strong></td>
                                                <td id="supplier-web_site"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Director</strong></td>
                                                <td id="supplier-director"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / end  supplier modal details -->
                    </div>
                    <div role="tabpanel" class="tab-pane fade @if($tab=='stocks') active in @endif" id="tab_content2"
                         aria-labelledby="profile-tab">

                        @if(\App\Location::AvailableLocations($article->id)->count()>0)
                            <div class="pull-right">
                                <a href="{{url('stocks/'.$article->id)}}" class="btn btn-primary">Add a new Stock</a>
                            </div>
                        @endif
                        <br>
                        @if(session()->has('success_stock'))
                            <div class="alert alert-success clear">
                                <p>{{session()->get('success_stock')}}</p>
                            </div>
                        @endif
                        @php
                            $total=0;
                        @endphp
                        <table class="table table-hover" id="stocks_table">
                            <thead>
                            <tr>
                                <th>Site</th>
                                <th>Location</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($article->stocks as $stock)
                                <tr>
                                    <td>{{$stock->site}}</td>
                                    <td>{{$stock->location->code}}</td>
                                    <td>
                                        <form id="form-{{$stock->id}}" method="post"
                                              action="{{route('edit.stock',['stock'=>$stock->id])}}">
                                            @csrf
                                            @method('put')
                                            <input value="{{$stock->qte}}" name="qte" required=""/>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="#" onclick="event.preventDefault();
                                                document.getElementById('form-{{$stock->id}}').submit();"
                                           class="fa fa-refresh"></a>
                                        @if($stock->commands->count()==0)
                                            <a href="#" data-toggle="modal" onclick="pass_stock('{{$stock->id}}')"
                                               data-target=".bs-example-modal-stock" style="margin-left: 10px;"
                                               class="fa fa-trash"></a>
                                        @endif
                                    </td>
                                    @php $total=$total+$stock->qte; @endphp
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2"><b class="text-center">
                                        <center>Total Quantity</center>
                                    </b></td>
                                <td><b>{{$total}}</b></td>
                            </tr>
                            </tbody>
                        </table>
                        {{--modal for  stock--}}
                        <div class="modal fade bs-example-modal-stock" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <h6><strong>Are you sure to delete that stock?!</strong></h6>
                                    </div>
                                    <form id="delete_stock_form" method="post">
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
                        <!-- / end  stock's modals -->
                    </div>
                    <div role="tabpanel" class="tab-pane fade @if($tab=='replacements') active in @endif"
                         id="tab_content3"
                         aria-labelledby="profile-tab">
                        @if($replacements_list->count()>0)
                            <form action="{{url('articles/'.$article->id.'/replace')}}" method="post"
                                  class="form-horizontal">
                                <div class="form-group">
                                    <label for="article" class="control-label col-md-3 col-sm-3 col-xs-12">Select an
                                        article</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <div class="input-group">
                                            <select id="article" class="form-control" name="article">
                                                @foreach($replacements_list as $item)
                                                    <option value="{{$item->id}}">{{$item->code}}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-btn">
                                              <button type="submit" class="btn btn-primary">Replace</button>
                                          </span>
                                            @csrf
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @elseif($replacements_list->count()==0 && $article->replacements->count()==0)
                            <div class="alert alert-warning">
                                <strong>There is no available articles to add</strong>
                            </div>
                        @endif
                        @if(session()->has('success_replace'))
                            <div class="alert alert-success">
                                <p>{{session()->get('success_replace')}}</p>
                            </div>
                        @endif
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Model</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($article->replacements as $item)
                                <tr>
                                    <td>{{$item->replacement->code}}</td>
                                    <td>{{$item->replacement->model}}</td>
                                    <td>
                                        @php
                                            $replacement=$item->replacement;
                                        @endphp
                                        <a href="#" data-toggle="modal"
                                           onclick=
                                           "pass_article_details('{{$replacement->code}}','{{$replacement->description}}',
                                                   '{{$replacement->model}}','{{$replacement->weight}}','{{$replacement->volume}}',
                                                   '{{$replacement->added_in}}','{{$replacement->manufacturer?$replacement->manufacturer->code:''}}')"
                                           data-target=".bs-example-modal-article-details"><i
                                                    class="fa fa-eye"></i></a>
                                        <a href="#" data-toggle="modal" style="margin-left: 10px;"
                                           onclick="pass_item('{{$item->id}}')"
                                           data-target=".bs-example-modal-replace"><i
                                                    class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{--modal for  replace--}}
                        <div class="modal fade bs-example-modal-replace" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <h6><strong>Are you sure to remove this replace?!</strong></h6>
                                    </div>
                                    <form id="delete_item_form" method="post">
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
                        <!-- / end  stock's replace -->

                        {{--modal for  article details--}}
                        <div class="modal fade bs-example-modal-article-details" tabindex="-1" role="dialog"
                             aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                    aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel2">Details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><strong>Code</strong></td>
                                                <td id="article-code"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Description</strong></td>
                                                <td id="article-description"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Model</strong></td>
                                                <td id="article-model"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Weight (kg)</strong></td>
                                                <td id="article-weight"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Volume (cubic decimeter)</strong></td>
                                                <td id="article-volume"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Added in</strong></td>
                                                <td id="article-added_in"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Manufacturer</strong></td>
                                                <td id="article-manufacturer"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / end  article modeal details -->


                    </div>
                    <div role="tabpanel" class="tab-pane fade @if($tab=='costs') active in @endif"
                         id="tab_content4" aria-labelledby="home-tab">
                        @if(session()->has('success_cost'))
                            <div class="alert alert-success">
                                <p>{{session()->get('success_cost')}}</p>
                            </div>
                        @endif
                        <div class="pull-right">
                            <a href="{{url('articles/'.$article->id.'/cost')}}" class="btn btn-primary">Add a new
                                Cost</a>
                        </div>
                        @php
                            $totalCost=0;
                            $totalQte=0;
                        @endphp
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
                                            <td>
                                                <form id="form-{{$cost->id}}-cost" method="post" action="{{route('cost.edit',['cost'=>$cost->id])}}">
                                                    @csrf
                                                    @method('put')
                                                    <input value="{{$cost->qte}}" name="qte">
                                                </form>
                                            </td>
                                            <td>
                                                <a href="#" onclick="event.preventDefault();
                                                        document.getElementById('form-{{$cost->id}}-cost').submit();"
                                                   class="fa fa-refresh"></a>
                                                <a href="#" data-toggle="modal" style="margin-left: 10px" onclick="pass_cost('{{$cost->id}}')"
                                                   data-target=".bs-example-modal-cost"><i
                                                            class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @php
                                            $totalCost=$cost->qte*$cost->cost+$totalCost;
                                            $totalQte=$totalQte+$cost->qte;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td><b>Total cost</b></td>
                                        <td><b>{{$totalCost}}</b></td>
                                        <td><b>Total Quantity</b></td>
                                        <td><b>{{$totalQte}}</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Adjusted unitary cost (DH)</b></td>
                                        <td><b>{{$totalQte==0?'0':number_format((float) $totalCost/$totalQte,2,'.','')}}</b>
                                        </td>
                                    </tr>
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
                    <div role="tabpanel" class="tab-pane fade @if($tab=='purposes') active in @endif" id="tab_content5"
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
                                                  <a href="#" data-toggle="modal"
                                                     onclick="pass_purpose('{{$purpose->id}}')"
                                                     data-target=".bs-example-modal-purposes"><i
                                                              class="fa fa-trash pull-right"></i></a>
                                    </span>
                                </li>
                            @endforeach
                            {{--modal for  cost--}}
                            <div class="modal fade bs-example-modal-purposes" tabindex="-1" role="dialog"
                                 aria-hidden="true">
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
            @if($totalQte!=$total)
                <div class="alert alert-danger">
                    <b>Quantities must be equalized</b>
                </div>
            @endif
        </div>
    </div>
@stop

@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script>
        function pass_supplier(id_supplier) {
            $('#delete_supplier_form').attr('action', '{{url('articles')}}' + '/' + id_supplier + '/supplier');
        }

        function pass_stock(id_stock) {
            $('#delete_stock_form').attr('action', '{{url('stocks')}}' + '/' + id_stock);
        }

        function pass_item(id_item) {
            $('#delete_item_form').attr('action', '{{url('articles/replace')}}' + '/' + id_item);
        }

        function pass_cost(id_cost) {
            $('#delete_cost_form').attr('action', '{{url('articles')}}' + '/' + id_cost + '/delete');
        }

        function pass_purpose(id_purposes) {
            $('#delete_purposes_form').attr('action', '{{url('articles')}}' + '/' + id_purposes + '/delete/purpose');
        }

        function pass_article_details(code, description, model, weight, volume, added_in, manufacturer) {
            $('#article-code').html(code);
            $('#article-description').html(description);
            $('#article-model').html(model);
            $('#article-weight').html(weight);
            $('#article-volume').html(volume);
            $('#article-added_in').html(added_in);
            $('#article-manufacturer').html(manufacturer);
        }

        function pass_supplier_details(code, name, country, city, zip_code, phone, address, fax, email, web_site, director) {
            $('#supplier-code').html(code);
            $('#supplier-name').html(name);
            $('#supplier-country').html(country);
            $('#supplier-city').html(city);
            $('#supplier-zip_code').html(zip_code);
            $('#supplier-phone').html(phone);
            $('#supplier-address').html(address);
            $('#supplier-fax').html(fax);
            $('#supplier-email').html(email);
            $('#supplier-web_site').html(web_site);
            $('#supplier-director').html(director);
        }


        $(document).ready(function () {
            // $('#stocks_table').DataTable();
        });
    </script>
@stop