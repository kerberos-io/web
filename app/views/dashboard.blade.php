    @extends('template')
    
@section('content')
    <div id="page-wrapper">
        <div id="dashboard" class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <h2>
                        <i class="fa fa-video-camera"></i> Stream
                     </h2>
                        <ul class="nav navbar-right top-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i href="#"class="fa fa-fw fa-bars"></i> select view <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="active">
                                        <a class="stream"><i href="#"class="fa fa-fw fa-cloud"></i> Live view</a>
                                    </li>
                                    <li>
                                        <a class="activity"><i href="#"class="fa fa-fw fa-refresh"></i> Last activity</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                   
                    <div id="activity-sequence">
                        <ul id="activity-choice">
                            <li class="stream">
                                <div id="livestream"></div>
                            </li>
                            <li class="activity">
                                <canvas id="latest-activity-sequence"></canvas>
                            </li>
                        </ul>
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
                        // on page load, hide all except live stream
                        $("#activity-choice li").hide();
                        $("#activity-choice li.stream").show();
                        
                        $("ul.dropdown-menu li").click(function(event)
                        {
                            // hide all
                            $("#activity-choice li").hide();
                            $("ul.dropdown-menu li").removeClass("active");
                            
                            // show selected
                            var attr = $(event.target).attr("class");
                            $("#activity-choice li." + attr).show();
                            $(event.target).parent().addClass("active");
                        });
 
                        
                        require(["app/controllers/dashboard_live",
                                 "app/controllers/dashboard_sequencer",
                                 "app/controllers/dashboard_pie",
                                 "app/controllers/dashboard_graph",
                                 "app/controllers/dashboard_radar"
                                 ], 
                        function(Streamer, Sequencer, Pie, Graph, Radar)
                        {
                            Streamer.initialize(
                            {
                                element: "livestream",
                                host: "<?=ltrim(URL::to('/'), 'http://')?>",
                                port: 8888,
                                width: '100%',
                                callback: function(){}
                            });
                            
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