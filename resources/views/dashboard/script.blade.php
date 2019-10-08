<script>
$(document).ready(function () {
    var labels = [];
    var stoppingtimes = [];
    var interventiontimes = [];
    for (var i = 0; i < 52; i++) {
        labels.push((i + 1))
    }
    var ctx = document.getElementById("graphByAllMachine");
    var lineChart = new Chart(ctx, {
        type: 'line',
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
                    data:[]
                }
            ]
        }
    });
    $('#year').change(function () {
        loadGraph(this.value);
    });
    loadGraph();
    function loadGraph(year = '{{\Carbon\Carbon::now()->year}}') {
        var url = '{{url('intervention-request/all')}}' + '/' + year;
        $.getJSON(url, function (response) {
            lineChart.data.datasets[0].data = response.stopping_times;
            lineChart.data.datasets[1].data = response.intervention_times;
            lineChart.update();
        })
    }
    $('#default').change(function () {
        var value=this.value;
        var defaults=[];
        for (var i = 0; i < 52; i++) {
            defaults.push((value));
        }
        lineChart.data.datasets[2].data = defaults;
        lineChart.update();
    });
    $('#default').change();
    $.getJSON('{{url('commands-percentage')}}',function (resule) {
        var ctxCommand=document.getElementById('commands');
        var myPieChart = new Chart(ctxCommand,{
            type: 'pie',
            data: {
                datasets: [{
                    data: [resule.valid, resule.pending],
                    backgroundColor:['#2A3F54','#33cccc'],
                    labels: {
                        render: 'percentage',
                        precision: 2
                    }
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: [
                    '% Valid',
                    '% Pending',
                ],

            },
        });
    });
   $.getJSON('{{url('manufacturers-graph')}}',function (result) {
       var manufacturers=[];
       for(var i=0;i<result.length;i++)
           manufacturers.push(result[i].manufacturer);
       var values=[];
       for(var i=0;i<result.length;i++)
           values.push(result[i].nb);
       var ctx = document.getElementById("manufacturers");
       var chart = new Chart(ctx, {
           type: 'bar',
           data: {
               labels: manufacturers,
               datasets: [{
                   label: 'number of equipments',
                   backgroundColor: "#33cccc",
                   data: values
               }]
           },

           options: {
               scales: {
                   yAxes: [{
                       ticks: {
                           beginAtZero: true
                       }
                   }]
               }
           }
       });
   });
   $.getJSON('{{url('suppliers-graph')}}',function (result) {
       var suppliers=[];
       for(var i=0;i<result.length;i++)
           suppliers.push(result[i].supplier);
       var values=[];
       for(var i=0;i<result.length;i++)
           values.push(result[i].nb);
       var ctx = document.getElementById("suppliers");
       var chart = new Chart(ctx, {
           type: 'bar',
           data: {
               labels: suppliers,
               datasets: [{
                   label: 'number of equipments',
                   backgroundColor: "#2A3F54",
                   data: values
               }]
           },

           options: {
               scales: {
                   yAxes: [{
                       ticks: {
                           beginAtZero: true
                       }
                   }]
               }
           }
       });
   });
   $.getJSON('{{url('employees-job')}}',function (result) {
       var jobs=[];
       for(var i=0;i<result.length;i++)
           jobs.push(result[i].job);
       var values=[];
       for(var i=0;i<result.length;i++)
           values.push(result[i].nb);
       var ctx = document.getElementById("jobs");
       var chart = new Chart(ctx, {
           type: 'bar',
           data: {
               labels: jobs,
               datasets: [{
                   label: 'number of employees',
                   backgroundColor: "#2A3F54",
                   data: values
               }]
           },

           options: {
               scales: {
                   yAxes: [{
                       ticks: {
                           beginAtZero: true
                       }
                   }]
               }
           }
       });
   });

})
</script>