@extends('layout.admin')
@section('title')Preventive Interventions management @endsection
@section('x_title')
    <h2>Intervention list</h2>
    @can('create',\App\PreventiveIntervention::class)
        <a href="{{route('preventive-interventions.create')}}" class="btn btn-primary xs" style="float: right;">Add a
            new
            Preventive Intervention</a>
    @endcan
    <div class="clearfix"></div>
@endsection
@section('content')
    <div class="" role="tabpanel" data-example-id="togglable-tabs">

        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="active"
            ><a href="#tab_content1" id="home-tab" role="tab"
                data-toggle="tab" aria-expanded="true">Intervention preventive table</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content2"
                                                role="tab"
                                                id="profile-tab"
                                                data-toggle="tab"
                                                aria-expanded="false">Calendar</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade active in"
                 id="tab_content1" aria-labelledby="home-tab">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        <b>{{session()->get('success')}}</b>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-hover" id="table">
                        <thead>
                        <tr>
                            <th>Machine</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Written by</th>
                            {{--<th>Date</th>--}}
                            <th>Intervention start</th>
                            <th>Intervention end</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- Modal -->
                <div id="validation" class="modal fade" role="dialog">
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
                                <h6><strong>Are you sure to cancel validation ?!</strong></h6>
                            </div>
                            <form id="validation_form" method="post">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                    </button>
                                    @method('put')
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-danger">Confirm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="delete" class="modal fade" role="dialog">
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
                                <h6><strong>Are you sure to delete validation ?!</strong></h6>
                            </div>
                            <form id="delete_form" method="post">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                    </button>
                                    @method('DELETE')
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-danger">Confirm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade"
                 id="tab_content2" aria-labelledby="home-tab">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <div id="calendarShow" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Intervention information</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Machine</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Written by</th>
                            <th>Intervention start</th>
                            <th>Intervention end</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td id="tdMachine"></td>
                            <td id="tdStatus"></td>
                            <td id="tdDescription"></td>
                            <td id="tdWrittenBy"></td>
                            <td id="tdStart"></td>
                            <td id="tdEnd"></td>
                        </tr>
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
@stop
@section('css')
    <link href="{{asset('template/datatable/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/datatable/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('calander_assets/fullcalendar.min.css')}}">

@stop
@section('script')
    <script src="{{asset('template/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('template/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('calander_assets/moment.min.js')}}"></script>
    <script src="{{asset('calander_assets/fullcalendar.min.js')}}"></script>
    <script>
        function pass_preventive(id) {
            $('#validation_form').attr('action', '{{url('preventive-intervention')}}' + '/' + id + '/validation-cancel');
        }

        function delete_provention(id) {
            $('#delete_form').attr('action', '{{url('preventive-intervention')}}' + '/' + id);
        }

        $(document).ready(function () {
            $('#table').DataTable({
                responsive: true,
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 1},
                    {responsivePriority: 3, targets: 5},
                ],

                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('preventive.ajax') }}",
                "columns": [
                    {"data": "machine", 'name': 'equipments.code'},
                    {"data": "status"},
                    {"data": "description"},
                    {"data": "written_by", 'name': 'employees.name'},
                    // {"data": "date", 'searchable': false},
                    {"data": "intervention_start", 'searchable': false},
                    {"data": "intervention_end", 'searchable': false},
                    {"data": "action", 'name': 'action', 'orderable': false, 'searchable': false}
                ],
                "order": [[4, "desc"]]
            });
        });
        $('#calendar').fullCalendar(
            {
                editable: false,
                header:
                    {
                        left: 'prev, next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay',
                    },
                events: '{{url('/preventive-intervention/calendar')}}',
                selectable: true,
                selectHelper: true,
                select: function (start, end, allDay) {

                },
                eventClick: function (event) {
                    console.log(event.start.format('DD/MM/YYYY H:m'));
                    $('#tdMachine').html(event.machine);
                    $('#tdStatus').html(event.status);
                    $('#tdDescription').html(event.title);
                    $('#tdWrittenBy').html(event.written_by);
                    $('#tdStart').html(event.start.format('DD/MM/YYYY H:m'));
                    $('#tdEnd').html(event.end.format('DD/MM/YYYY H:m'));
                    $('#calendarShow').modal('show')
                },
                viewRender: function (view, element) {
                },
                timeFormat: 'H(:mm)',
            }
        );
    </script>
@stop