@extends('template')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div id="system" class="col-lg-6">
                    <h2><i class="fa fa-desktop"></i> System</h2>
                    @if($system->diskAlmostFull())
                        <div style="display: table" class="alert alert-danger" role="alert">Hey, your disk is almost full. Please remove some images..</div>
                    @endif
                    <div>
                        System is online for {{$system->getUptime()['text']}}
                    </div>
                    <div>
                        <h3>OS specifications</h3>
                        <table class="table">
                            @if($system->getBoard() != '')
                            <tr><td>Board</td><td>{{$system->getBoard()}}</td></tr>
                            @endif
                            @if($system->getModel() != '')
                            <tr><td>Model</td><td>{{$system->getModel()}}</td></tr>
                            @endif
                            <tr><td>OS</td><td>{{$system->getOS()}}</td></tr>
                            <tr><td>Kernel</td><td>{{$system->getKernel()}}</td></tr>
                            <tr><td>Hostname</td><td>{{$system->getHostName()}}</td></tr>
                        </table> 
                    </div>
                    <div>
                        <h3>Architecture</h3>
                        This machine has {{count($system->getCPUs())}} {{$system->getCPUArchitecture()}} CPU's running with an average load of <b>{{$system->getAverageLoad()}}</b>.<br/>
                        <ul class="cpus">
                        @foreach($system->getCPUs() as $cpu)
                           <li class="cpu">{{$cpu['Model']}}</li>
                        @endforeach
                        </ul>
                    </div>
                    <div>
                        <h3>Disk specifications</h3>
                        There are {{count($system->getMounts())}} hard disks available on this machine.
                        
                        <div class="disks">
                        @foreach($system->getMounts() as $key => $mount)
                        <div class="disk">
                            {{$mount['device']}} 
                                        <div class="progress">
                                          <div class="progress-bar {{($mount['used_percent'] < 50) ? 'progress-bar-success' : (($mount['used_percent'] < 75) ? 'progress-bar-warning' : 'progress-bar-danger')}}" role="progressbar" aria-valuenow="{{$mount['used_percent']}}"
                                          aria-valuemin="0" aria-valuemax="100" style="width:{{$mount['used_percent']}}%">
                                            {{$mount['used_percent']}}%
                                          </div>
                                        </div>
                            {{$mount['text']['used']}}/{{$mount['text']['size']}}
                         </div>
                         @endforeach
                         </div>    
                    </div>
                    <div>
                        <h3>Network specifications</h3>
                        <table class="table table-striped">
                            <tr>
                            <th>Device</th>
                            <th>Received</th>
                            <th>Sent</th>
                            </tr>
                            @foreach($system->getNet() as $key => $interface)
                            <tr>
                                <td>{{$key}}</td>
                                <td>{{$interface['text']['recieved']}}</td>
                                <td>{{$interface['text']['sent']}}</td>
                            </tr>
                            @endforeach
                        </table> 
                    </div>
                </div>
                <div id="kerberos" class="col-lg-6">
                    <h2><i class="fa fa-user-secret"></i> Kerberos.io</h2>
                    <div>
                        Kerberos.io has two services running: the web and the machinery.
                        <h3>Versions</h3>
                        <table class="table">
                            <tr><td>Web</td><td>{{$system->getWebVersion()}}</td></tr>
                            <tr><td>Machinery</td><td>{{$system->getMachineryVersion()}}</td></tr>
                        </table> 
                        <h3>Statistics</h3>
                        <table class="table">
                            <tr><td># of images</td><td>{{$numberOfImages}}</td></tr>
                            <tr><td># of days</td><td>{{count($allDays)}}</td></tr>
                            <tr><td>Days</td>
                                <td>
                                @foreach($allDays as $day)
                           {{$day}}, 
                            @endforeach
                                </td></tr>
                        </table> 
                        <div id="system-actions">
                            <a id="download" href="{{URL::to('/')}}/api/v1/images/download">Download images</a>
                            <a id="clean">Remove images</a>
                        </div>
                    </div>
                </div>
                @if($system->isBuildroot())
                <div id="kios" class="col-lg-6">
                    <h2><i class="fa fa-linux"></i> Kios</h2>
                    <!--<div style="display: table" class="alert alert-warning" role="alert">Nice, a new version of KIOS is available!</div>-->
                    <div id="kios-versions">
                        <div class="load5 loadimage" style=""><div class="loader"></div></div>
                    </div>
                    <div id="upgrade-modal" data-remodal-id="upgrade">
                        <div class="modal-body"></div>
                    </div>
                </div>
                @endif
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <script type="text/javascript">
        require([_jsBase + 'main.js'], function(common)
        {
            require(["app/controllers/system"], function(System)
            {
                require(["remodal", "progressbar"], function(remodal, ProgressBar)
                {
                    var options = {
                        hashTracking: false,
                        closeOnAnyClick: false, 
                        closeOnEscape: false
                    };
                    var modal = $('[data-remodal-id=upgrade]').remodal(options);
 
                    // Set board and current version
                    System.setBoard("{{$system->getBoard()}}");
                    System.setCurrentVersion("{{$system->getCurrentVersion()}}");
                        
                    System.intialize(function()
                    {
                        // Bind events
                        $(".version").click(function(e)
                        {
                            var version = $(this).attr('id');
                            if(System.getCurrentVersion() == version) return false;
                            
                            version = System.versions[version];
                            var published_at = new Date(version.published_at);
                            
                            $("#upgrade-modal .modal-body").html("" +
                            "<h1>Release " + version.version + "</h1>" +                       
                            "<span>Published at " + published_at + "</span>" +                       
                            "<p>" + version.body + "</p>" +
                            '<a id="install">install</a>');
                            
                            modal.open();
                            
                            $("#install").click(function()
                            {   
                                $("#upgrade-modal").html(
                                '<h1>Downloading..</h1>' +
                                '<div id="percentage-downloaded"></div>');
                                
                                System.downloadVersion(version, function()
                                {
                                    // Hit when file has been downloaded
                                    $("#upgrade-modal").html(
                                        '<h1>Unzipping..</h1>' +
                                        '<div class="load5 loadimage" style=""><div class="loader"></div>');
                                    
                                    System.unzip(function()
                                    {
                                        // Hit when file has been unzipped
                                        $("#upgrade-modal").html(
                                            '<h1>Unpacking..</h1>' +
                                            '<div class="load5 loadimage" style=""><div class="loader"></div>');

                                        System.unpack(function()
                                        {
                                        
                                            // Hit when file has been unpacked
                                            $("#upgrade-modal").html(
                                            '<h1>Transferring..</h1>' +
                                            '<div class="load5 loadimage" style=""><div class="loader"></div>');

                                            System.transfer(function()
                                            {
                                                $("#upgrade-modal").html(
                                                    '<h1>System is rebooting..</h1>' +
                                                    '<div id="count-down"></div>');

                                                var waitingTime = 120000;

                                                var countDown = new ProgressBar.Circle('#count-down', {
                                                    color: '#943633',
                                                    strokeWidth: 3,
                                                    trailWidth: 1,
                                                    duration: waitingTime,
                                                    text: {
                                                        value: '100'
                                                    },
                                                    step: function(state, bar)
                                                    {
                                                        bar.setText(100 - (bar.value() * 100).toFixed(0));
                                                    }
                                                });

                                                countDown.animate(1);

                                                setInterval(function() { window.location.reload() }, waitingTime);
                                                
                                                System.reboot(function(){});
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            
                $("#clean").click(function()
                {
                    System.clean();
                });
            });
        });
    </script>
@stop