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
                    <script type="text/javascript">
                        // Render dashboard sequencer (latest sequence)
                        require([_jsBase + 'main.js'], function(common)
                        {
                            require(["jquery"], function($)
                            {
                                require(["app/controllers/dashboard_sequencer"], function(Sequencer)
                                {
                                    var config = {
                                        element: "canvas",
                                        direction:"-x",
                                        progressMode: "bar",
                                        progressShowImages: true,
                                        playMode: "loop",
                                        playInterval: 300,
                                    };

                                    $.get(_baseUrl + "/api/v1/images/latest_sequence", function(images)
                                    {
                                        config.images = images;
                                        Sequencer.initialize(config);
                                        Sequencer.attachTo(document.getElementById("latest-activity-sequence"));
                                        Sequencer.play();
                                    });
                                });
                            });
                        });
                    </script>
                </div>
                <div class="col-lg-6 hide-on-mobile">
                    <h2><i class="fa fa-pie-chart"></i> Overview</h2>
                    <!--<div id="morris-donut"></div>-->
                    <div id="time-donut-wrapper">
                        <canvas id="time-donut"></canvas>
                        <div id="time-donut-legend"></div>
                    </div>

                    <script type="text/javascript">
                        // Render dashboard graph (images per hour)
                        require([_jsBase + 'main.js'], function(common)
                        {
                            require(["app/controllers/dashboard_pie"]);
                        });
                    </script>
                </div>
                <div class="col-lg-6 hide-on-mobile">
                    <h2><i class="fa fa-clock-o"></i> Hour</h2>
                    <div id="time-graph">
                        <canvas id="time-chart"></canvas>
                    </div>

                    <script type="text/javascript">
                        // Render dashboard graph (images per hour)
                        require([_jsBase + 'main.js'], function(common)
                        {
                            require(["app/controllers/dashboard_graph"]);
                        });
                    </script>
                </div>
                <div class="col-lg-6 hide-on-mobile">
                    <h2><i class="fa fa-calendar"></i> Weekday</h2>
                    <div id="radar-graph">
                        <canvas id="radar-chart"></canvas>
                    </div>

                    <script type="text/javascript">
                        // Render dashboard graph (images per hour)
                        require([_jsBase + 'main.js'], function(common)
                        {
                            require(["app/controllers/dashboard_radar"]);
                        });
                    </script>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop