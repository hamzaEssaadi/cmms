@extends('layout.admin')
@section('title')Projects Details @endsection
@section('x_title')
    <h2>Projects list</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
  <div class="col-md-12">
      <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
          @foreach($projects as $key=>$project)
              <div class="panel">
                  <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse"
                     data-parent="#accordion" href="#collapse{{$key}}" aria-expanded="false" aria-controls="">
                      <h4 class="panel-title">{{str_limit($project->text,65)}} <i>{{date('d/m/Y',strtotime($project->start_date))}}</i></h4>
                  </a>
                  <div id="collapse{{$key}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne"
                       aria-expanded="false" style="height: 0px;">
                      <div class="panel-body">
                          <h4><u>Tasks</u></h4>
                          <table class="table table-hover">
                              <thead>
                              <tr>
                                  <th>Description</th>
                                  <th>Start date</th>
                                  <th>Duration</th>
                                  <th>Action</th>
                              </tr>
                              </thead>
                              <tbody>
                              @foreach($project->tasks as $task)
                                  <tr>
                                      <td>{{str_limit($task->text,65)}} </td>
                                      <td>{{date('d/m/Y',strtotime($task->start_date))}}</td>
                                      <td>{{$task->duration}} day(s)</td>
                                      <td><a href="{{url('/projects-details/'.$task->id)}}" target="_blank" data-toggle="tooltip" data-original-title="Details" class="fa fa-eye"></a></td>
                                  </tr>
                              @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          @endforeach
      </div>
  </div>
@stop