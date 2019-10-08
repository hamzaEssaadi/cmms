<!-- graph -->
<div id="chart" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width: 1200px; !important;">
        <div class="modal-content">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Annual intervention graph</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form-horizontal form-label-left align-content-center">
                        <div class="form-group">
                            <label class="control-label col-md-1 col-sm-3 col-xs-12">Year</label>
                            <div class="col-md-3 col-sm-9 col-xs-12">
                                <select id="year" class="form-control">
                                    @for($i=\Carbon\Carbon::now()->year-5;$i<\Carbon\Carbon::now()->year+1;$i++)
                                        <option @if(\Carbon\Carbon::now()->year==$i) selected=""
                                                @endif value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <label class="control-label col-md-1 col-sm-3 col-xs-12">Desired Time</label>
                            <div class="col-md-3 col-sm-9 col-xs-12">
                                <input type="number" value="50" class="form-control" id="default"/>
                            </div>
                        </div>
                    </form>
                    <canvas id="graphByAllMachine"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>