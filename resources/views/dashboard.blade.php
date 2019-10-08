@extends('layout.admin')
@section('active-dashboard') current-page @stop
@section('title')
    Dashboard
@endsection
@section('x_title')
    <h2>Statistics</h2>
    <div class="clearfix"></div>
@endsection

@section('description')
    description @endsection
@section('content')
    @php $user=\Illuminate\Support\Facades\Auth::user(); @endphp
    <div class="row">
        <div class="col-md-12 align-content-center ">
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div style="border-color: #2A3F54;" class="tile-stats">
                    <div class="icon"><i class="fa fa-area-chart color primary" id="annual_intervention"></i></div>
                    <div class="count color primary">{{\Carbon\Carbon::now()->year}}</div>
                    <br>
                   <h3 style="color: #2A3F54;">Annual intervention graph</h3>
                    <br>
                    <p> <a href="#" data-toggle='modal' data-target='#chart'>See details</a></p>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div style="border-color: #33cccc;" class="tile-stats">
                    <div class="icon"><i class="fa fa-tasks color secondary"></i></div>
                    <div class="count color secondary">{{$orderCount}}</div>
                    <br>
                    <h3 style="color: #33cccc">Work orders</h3>
                    <br>
                   <p><a href="{{route('work-orders.index')}}">See details</a></p>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="tile-stats border-red">
                    <div class="icon"><i class="fa fa-warning color red"></i></div>
                    <div class="count color red">{{\App\Article::ErrorsArticle()}}</div>
                    <br>
                    <h3 style="color: red;">Stocks errors</h3>
                    {{--<p><a href="{{route('preventive-interventions.index')}}">See details</a></p>--}}
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div style="border-color: #33cccc;" class="tile-stats">
                    <div class="icon"><i class="fa fa-calendar color secondary"></i></div>
                    <div class="count color secondary">{{$preventiveInterventionCount}}</div>
                    <br>
                    <h3 style="color: #33cccc;">Preventive interventions </h3>
                    <br>
                   <p><a href="{{route('preventive-interventions.index')}}">See details</a></p>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div style="border-color: #2A3F54;" class="tile-stats">
                    <div class="icon"><i class="fa fa-wrench color primary"></i></div>
                    <div class="count color primary">{{$requestCount}}</div>
                    <br>
                    <h3 style="color:#2A3F54">Intervention requests </h3>
                    <br>
                    <p><a href="{{route('interventions-requests.index')}}">See details</a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Equipments by supplier</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <canvas id="suppliers" style="width: 484px; height: 242px;" width="484" height="242"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Equipments by manufacturer</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <canvas id="manufacturers" style="width: 484px; height: 242px;" width="484" height="242"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Commands status</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <canvas id="commands" style="width: 484px; height: 242px;" width="484" height="242"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Employees by job</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <canvas id="jobs" style="width: 484px; height: 242px;" width="484" height="242"></canvas>
                </div>
            </div>
        </div>


    </div>
    @include('dashboard.charts');
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('template/icheck/flat/green.css')}}"/>
    <style>
        .tile-stats{
            border-radius: 10px;
            border-width: 3px;
            height: 168px;
            /*border-color: #33cccc;*/
        }
        .primary
        { color: #2A3F54;}
        .secondary{ color:#33cccc; }
        @media only screen
        and (min-device-width : 320px)
        and (max-device-width : 480px) {
            .tile-stats{
                border-radius: 10px;
                border-width: 3px;
                height: 185px;

            }
        }
    </style>
@endsection
@section('script')
    <script src="{{asset('template/charts/Chart.min.js')}}"></script>
{{--    <script src="{{asset('template/icheck/icheck.min.js')}}"></script>--}}
    @include('dashboard.script')
@stop
