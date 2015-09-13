    @extends('template')
    
@section('content')
    <div id="page-wrapper">
        <div id="dashboard" class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <h2><i class="fa fa-video-camera"></i> Activity</h2>
                    <div id="activity-sequence">
                        <canvas id="latest-activity-sequence"></canvas>
                    </div>
                </div>
                <div class="col-lg-6 hide-on-mobile">
                    <h2><i class="fa fa-pie-chart"></i> Overview</h2>
                    <!--<div id="morris-donut"></div>-->
                    <div id="time-donut-wrapper">
                        <canvas id="time-donut"></canvas>
                        <div id="time-donut-legend"></div>
                    </div>
                </div>
                <div class="col-lg-6 hide-on-mobile">
                    <h2><i class="fa fa-clock-o"></i> Hour</h2>
                    <div id="time-graph">
                        <canvas id="time-chart"></canvas>
                    </div>
                </div>
                <div class="col-lg-6 hide-on-mobile">
                    <h2><i class="fa fa-calendar"></i> Weekday</h2>
                    <div id="radar-graph">
                        <canvas id="radar-chart"></canvas>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                // Render dashboard sequencer (latest sequence)
                require([_jsBase + 'main.js'], function(common)
                {
                    require(["jquery"], function($)
                    {
                        require(["app/controllers/dashboard_sequencer",
                                 "app/controllers/dashboard_pie",
                                 "app/controllers/dashboard_graph",
                                 "app/controllers/dashboard_radar"
                                 ], 
                                function(Sequencer, Pie, Graph, Radar)
                        {
                            Sequencer.initialize(
                            {
                                element: "canvas",
                                direction:"-x",
                                progressMode: "bar",
                                progressShowImages: true,
                                playMode: "loop",
                                playInterval: 300,
                                url: _baseUrl + "/api/v1/images/latest_sequence",
                                callback: function()
                                {
                                    if ($(window).width() >= 768)
                                    {
                                        Pie.initialize(
                                        {
                                            url: "/api/v1/images/perday/3",
                                            callback: function()
                                            {
                                                Graph.initialize(
                                                {
                                                    url: _baseUrl + "/api/v1/images/perhour/3",
                                                    callback: function()
                                                    {
                                                        Radar.initialize(
                                                        {
                                                            url: _baseUrl + "/api/v1/images/perweekday/1",
                                                            callback: function (){}
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    }
                                }
                            });
                        });
                    });
                });
            </script>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop