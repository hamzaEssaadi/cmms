@extends('layout.admin')
@section('x_title')
    <h1>calendar</h1>
    <div class="clearfix"></div>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
           <form method="post" action="{{url('/test')}}" enctype="multipart/form-data">
               <div class="form-group">
                 <input type="file" class="form-control" name="image" >
                   @csrf
                   <button type="submit">go</button>
               </div>
           </form>
            <div id="calendar">
            </div>

        </div>
        <div class="col-md-12"><div id="gantt_here" style="height: 500px; width: 100%;"></div></div>

    </div>

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('calander_assets/fullcalendar.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/switchery/switchery.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('gantt/dhtmlxgantt.css')}}">
@stop
@section('script')
    <script src="{{asset('calander_assets/moment.min.js')}}"></script>
    <script src="{{asset('calander_assets/fullcalendar.min.js')}}"></script>
    <script src="{{asset('template/switchery/switchery.min.js')}}"></script>
    <script src="{{asset('gantt/dhtmlxgantt.js')}}"></script>
    <script>

        $('#calendar').fullCalendar(
            {
                editable: false,
                header:
                    {
                        left: 'prev, next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay',
                    },
                events:'{{url('/events')}}',
                selectable: true,
                selectHelper: true,
                select:function (start,end,allDay) {
                    var title=prompt("Enter event title");
                    if(title) {
                        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                        alert(start);
                    }
                },
                eventClick:function (event) {
                  console.log(event.title);
                },
                viewRender : function(view,element) {
                    var moment = $('#calendar').fullCalendar('getDate');
                    // alert("The current date of the calendar is " + moment.format('M'));
                },
                timeFormat: 'H(:mm)'
            }
        );
        gantt.init("gantt_here");
    </script>
@stop
