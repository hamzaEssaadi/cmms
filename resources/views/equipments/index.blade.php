@extends('layout.admin')
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/datatable/responsive.bootstrap.min.css')}}" rel="stylesheet">
@stop

@section('title')Equipments management @endsection
@section('x_title')
    <h2>Equipments list</h2>
    <a href="{{route('equipments.create')}}" class="btn btn-primary xs" style="float: right;">Add a new Equipment</a>
    <div class="clearfix"></div>
@endsection
@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            <b>{{session()->get('success')}}</b>
        </div>
    @endif
    <table id="table" class="table table-hover dt-responsive nowrap">
        <thead>
        <tr>
            <th>Code</th>
            <th>Serial number</th>
            <th>Model number</th>
            <th>Type</th>
            <th>Purchase date</th>
            <th>Warranty expiration date</th>
            <th>Starting date</th>
            <th>Life time (years)</th>
            <th>Security note</th>
            <th>Location</th>
            <th>Department</th>
            <th>Supplier</th>
            <th>Manufacturer</th>
            <th>Responsible</th>
            <th>Contract</th>
            <th>In service</th>
            <th>Cost (DH)</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($equipments as $equipment)
            <tr>
                <td>{{$equipment->code}}</td>
                <td>{{$equipment->serial_number}}</td>
                <td>{{$equipment->model_number}}</td>
                <td>{{$equipment->equipment_type->code}}</td>
                <td>
                    <span class="hidden">{{$equipment->purchase_date}}</span> {{date('d/m/Y',strtotime($equipment->purchase_date))}}
                </td>
                <td>
                    <span class="hidden">{{$equipment->warranty_expiration_date}}</span>{{date('d/m/Y',strtotime($equipment->warranty_expiration_date))}}
                </td>
                <td>
                    <span class="hidden">{{$equipment->starting_date}}</span>{{date('d/m/Y',strtotime($equipment->starting_date))}}
                </td>
                <td>{{$equipment->life_time}}</td>
                <td>{{str_limit($equipment->security_note,20)}}</td>
                <td>{{$equipment->location->code}}</td>
                <td>{{$equipment->department->code}}</td>
                <td>{{$equipment->supplier->code}}</td>
                <td>{{$equipment->manufacturer->code}}</td>
                <td>{{$equipment->responsible->name}}</td>
                <td>{{$equipment->contract}}</td>
                <td>{{$equipment->in_service==1?'yes':'no'}}</td>
                <td>{{$equipment->cost}}</td>
                <td>
                    <a  href="{{route('equipments.edit',['equipment'=>$equipment->id])}}">
                        <i title="Edit" class="fa fa-edit"></i></a>
                    <a href="{{route('equipments.show',['equipment'=>$equipment->id])}}"><i title="show"
                                                                                            class="fa fa-eye"></i></a>
                    <a href="{{route('technical-drawing',['equipment'=>$equipment->id])}}"><i title="photos"
                                                                                              class="fa fa-image"></i></a>
                    @php $year=\Carbon\Carbon::now()->year;$id=$equipment->id @endphp
                    <a href="#" onclick="loadGraph('{{$id}}')" data-toggle='modal' data-target='#chart'><i
                                title="see intervention graph" class="fa fa-line-chart"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- graph -->
    <div id="chart" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" style="width: 1200px; !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Interventions graph</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left align-content-center">
                        <div class="form-group">
                            <label class="control-label col-md-1 col-sm-3 col-xs-12">Year</label>
                            <div class="col-md-3 col-sm-9 col-xs-12">
                                <select id="year" class="form-control">
                                    @for($i=\Carbon\Carbon::now()->year-5;$i<\Carbon\Carbon::now()->year+5;$i++)
                                        <option @if(\Carbon\Carbon::now()->year==$i) selected=""
                                                @endif value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <label class="control-label col-md-1 col-sm-3 col-xs-12">Desired Time</label>
                            <div class="col-md-3 col-sm-9 col-xs-12">
                                <input type="number" value="50" class="form-control" id="desired"/>
                            </div>
                        </div>
                    </form>
                    <canvas id="graph"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('template/charts/Chart.min.js')}}"></script>

    {{--    <script src="{{asset('template/datatable/responsive.bootstrap.min.css')}}"></script>--}}
    <script>
        $(document).ready(function () {
            $('#table').DataTable({responsive: true});
        });
        var stoppingtimes = [];
        var interventiontimes = [];
        var labels = [];
        for (var i = 0; i < 52; i++) {
            labels.push((i + 1))
        }
        var currenId;
        var ctx = document.getElementById("graph").getContext('2d');
        var lineChart = new Chart(ctx, {
            options: {
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Hours'
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Weeks'
                        }
                    }]
                }
            },
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Stopping time (hours)",
                    backgroundColor: "rgba(38, 185, 154, 0.31)",
                    borderColor: "rgba(38, 185, 154, 0.7)",
                    pointBorderColor: "rgba(38, 185, 154, 0.7)",
                    pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointBorderWidth: 1,
                    data: stoppingtimes
                }, {
                    label: "Intervention time (hours)",
                    backgroundColor: "rgba(3, 88, 106, 0.3)",
                    borderColor: "rgba(3, 88, 106, 0.70)",
                    pointBorderColor: "rgba(3, 88, 106, 0.70)",
                    pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(151,187,205,1)",
                    pointBorderWidth: 1,
                    data: interventiontimes
                },
                    {
                        label: 'Desired time (hours)',
                        data: []
                    }
                ]
            },
        });

        function loadGraph(id) {
            console.log(lineChart);
            var year = $('#year').val();
            currenId = id;
            var url = '{{url('intervention-request')}}/' + id + '/year/' + year;

            $.getJSON(url, function (result) {
                stoppingtimes = [];
                interventiontimes = [];
                stoppingtimes = result.stopping_times;
                interventiontimes = result.intervention_times;
                lineChart.data.datasets[0].data = stoppingtimes;
                lineChart.data.datasets[1].data = interventiontimes;
                lineChart.update();
            });
        }

        $('#year').change(function () {
            loadGraph(currenId);
        });
        $('#desired').change(function () {
            var value = this.value;
            var defaults = [];
            for (var i = 0; i < 52; i++) {
                defaults.push((value));
            }
            lineChart.data.datasets[2].data = defaults;
            lineChart.update();
        });
        $('#desired').change();
    </script>
@stop