<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CMMS</title>

    <!-- Bootstrap -->

    <link href="{{asset('template/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">

<!-- Font Awesome -->
    {{--<link src="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">--}}
    <link href="{{asset('template/css/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/css/custom.min.css')}}" rel="stylesheet">
    @yield('css')

</head>
<body class="nav-md">
@php $user=\Illuminate\Support\Facades\Auth::user(); @endphp
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    {{--<a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>CMMS</span></a>--}}
                    <center>
{{--                        <img src="{{asset('logos/app_logo.png')}}" style="margin-top: 1.5em; margin-bottom: 1.5em;" class="img-responsive" width="75" height="25"></svg>--}}
                        <img src="{{asset('logos/app_logo.svg')}}" class="img-responsive" style="width: 100px; margin-top:10px; "/>
                    </center>
                </div>
                <div class="clearfix"></div>
                <br>
                <br>
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="{{asset('emplys/images/'.$user->photo())}}" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>{{$user->name}}</h2>
                    </div>
                </div>
                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>Menu</h3>
                        <ul class="nav side-menu">
                            <li class="@yield('active-dashboard')"><a href="{{url('/')}}"><i
                                            class="fa fa-dashboard"></i>Dashboard
                                    {{--({{$user->role}})<br>--}}
                                    {{--{{$user->employee_id}}--}}
                                </a></li>
                            @if(\Illuminate\Support\Facades\Auth::user()->role=='super_admin' ||
                             Illuminate\Support\Facades\Auth::user()->role=='rh_manager')
                                <li><a><i class="fa fa-briefcase"></i>ُُEmployees <span
                                                class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{url('jobpositions')}}">Job position codes</a></li>
                                        <li><a href="{{url('employees')}}">Employees management</a></li>
                                        <li><a href="{{url('employees-deleted')}}">Deleted Employees</a></li>
                                        <li><a href="{{route('users.index')}}">Users Management</a></li>
                                    </ul>
                                </li>
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::user()->role=='stock_manager' ||
                                \Illuminate\Support\Facades\Auth::user()->role=='super_admin')
                                <li><a href="{{url('providers/supplier')}}"><i
                                                class="fa fa-product-hunt"></i>Suppliers</a></li>
                                <li><a href="{{url('providers/manufacturer')}}"><i
                                                class="fa fa-building"></i>Manufacturers</a></li>

                                <li><a><i class="fa fa-building-o"></i>Stocks<span
                                                class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{url('locations')}}">Location codes</a></li>
                                        <li><a href="{{url('articles')}}">Articles management</a></li>
                                        <li><a href="{{route('commands.all')}}">All commands</a></li>
                                    </ul>
                                </li>
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::user()->role=='maintenance_manager' ||
                              \Illuminate\Support\Facades\Auth::user()->role=='super_admin')
                                <li><a><i class="fa fa-cogs"></i>Equipments<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{url('departments')}}">Departments</a></li>
                                        <li><a href="{{url('disfunctions')}}">Disfunction causes</a></li>
                                        <li><a href="{{route('equipment-types.index')}}">Equipments type</a></li>
                                        <li><a href="{{route('equipments.index')}}">Equipments management</a></li>
                                    </ul>
                                </li>
                            @endif

                            <li><a href="{{route('interventions-requests.index')}}"><i
                                            class="fa fa-wrench"></i>Intervention Requests</a>
                            </li>
                            <li><a href="{{route('preventive-interventions.index')}}"><i
                                            class="fa fa-calendar"></i>Preventive Interventions</a></li>
                            @php $nborder=''; @endphp
                            @php
                                if($user->role!='super_admin')
                                {
                                    $nborder=\App\WorkOrder::WorkOrderCount();
                                    $count=$nborder[0]->nb;
                                    $nborder="<span class='label label-success pull-right'>$count</span>";

                            }
                            @endphp
                            <li><a><i class="fa fa-tasks"></i>Work orders<span
                                            class="fa fa-chevron-down"></span>{!! $nborder !!}</a>
                                <ul class="nav child_menu">
                                    <li><a href="{{route('work-order-types.index')}}">Work orders types</a></li>
                                    <li><a href="{{route('work-orders.index')}}">Work orders</a></li>
                                </ul>
                            </li>
                            @can('index',\App\Task::class)
                                <li><a><i class="fa fa-calendar"></i>Projects<span
                                                class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{url('projects')}}">Gantt Chart</a></li>
                                        <li><a href="{{url('/projects-details')}}">Details</a></li>
                                    </ul>
                                </li>
                            @endcan
                            @if($user->role!='super_admin')
                                @php $countTask=\Illuminate\Support\Facades\Auth::user()
                                ->myTasks()[0]->nb;
                                 $countTask="<span class='label label-success pull-right'>$countTask</span>";
                                @endphp
                                <li>
                                    <a href="{{route('myTasks')}}"><i class="fa fa-check-square"></i>Your Tasks
                                    {!! $countTask !!}
                                    </a>
                                </li>
                            @endif
                            <li >
                                <a href="{{route('reports.index')}}"><i class="fa fa-file"></i>Reports</a>
                            </li>
                        </ul>

                    </div>

                </div>
                <!-- /sidebar menu -->


            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                {{$user->name}}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">

                                <li>
                                    @if($user->role!='super_admin')
                                        <a href="{{url('employees/'.$user->employee_id)}}"><i
                                                    class="fa fa-user pull-right"></i>Profile</a>
                                        @else
                                        <a href="{{route('profile.edit',['user'=>$user->id])}}"><i
                                                    class="fa fa-user pull-right"></i>Profile</a>
                                    @endif
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out pull-right"></i>
                                        Log Out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>@yield('title','title page')</h3>
                    </div>
                </div>
                <div class="clearfix"></div>
                @yield('location-nav')
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                @yield('x_title')
                            </div>
                            <div class="x_content">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                <b>CMMS Feather - Maintenance Management System</b>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="{{asset('template/js/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('template/js/bootstrap.min.js')}}"></script>
<script src="{{asset('template/js/custom.min.js')}}"></script>

@yield('script')

</body>