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
                        OS specifications: 
                        <ul>
                            @if($system->getBoard() != '')
                            <li>{{$system->getBoard()}}</li>
                            @endif
                            @if($system->getModel() != '')
                            <li>{{$system->getModel()}}</li>
                            @endif
                            <li>{{$system->getOS()}}</li>
                            <li>{{$system->getKernel()}}</li>
                            <li>{{$system->getHostName()}}</li>
                        </ul> 
                    </div>
                    <div>
                        {{count($system->getCPUs())}} CPU's:<br/>
                        Architecture: <span class="load">{{$system->getCPUArchitecture()}}</span><br/>
                        Average load: <span class="load">{{$system->getAverageLoad()}}</span><br/>
                        <ul>
                        @foreach($system->getCPUs() as $cpu)
                           <li>{{$cpu['Model']}} - {{$cpu['MHz']}} - {{$cpu['Vendor']}}</li>
                        @endforeach
                        </ul>
                    </div>
                    <div>
                        Disk specifications: 
                        <ul>
                            <li>
                                Hard disks:
                                <ul>
                                     @foreach($system->getHD() as $key => $disk)
                                    <li>{{$disk['device']}} - {{$disk['name']}} - {{$disk['text']['size']}}</li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                Mounts:
                                <ul>
                                     @foreach($system->getMounts() as $key => $mount)
                                    <li>
                                        {{$mount['device']}} - {{$mount['type']}} - {{$mount['text']['used']}}/{{$mount['text']['size']}}
                                        <div class="progress">
                                          <div class="progress-bar {{($mount['used_percent'] < 50) ? 'progress-bar-success' : (($mount['used_percent'] < 75) ? 'progress-bar-warning' : 'progress-bar-danger')}}" role="progressbar" aria-valuenow="{{$mount['used_percent']}}"
                                          aria-valuemin="0" aria-valuemax="100" style="width:{{$mount['used_percent']}}%">
                                            {{$mount['used_percent']}}%
                                          </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul> 
                    </div>
                    <div>
                        Network specifications: 
                        <ul>
                            @foreach($system->getNet() as $key => $interface)
                            <li>{{$key}} - Received: {{$interface['text']['recieved']}} - Sent: {{$interface['text']['sent']}}</li>
                            @endforeach
                        </ul> 
                    </div>
                </div>
                <div id="kerberos" class="col-lg-6">
                    <h2><i class="fa fa-user-secret"></i> Kerberos.io</h2>
                    <div>
                        Version: 
                        <ul>
                            <li>Web: {{$system->getWebVersion()}}</li>
                            <li>Machinery: {{$system->getMachineryVersion()}}</li>
                        </ul> 
                        Total images: {{$numberOfImages}}<br/>
                        Days: 
                        <ul>
                            @foreach($allDays as $day)
                            <li>{{$day}}</li>
                            @endforeach
                        </ul>
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
                        $(".version").click(function()
                        {
                            var version = $(this).attr('id');
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
                                    // Hit when file has ben downloaded
                                    $("#upgrade-modal").html(
                                        '<h1>Unpacking..</h1>' +
                                        '<div class="load5 loadimage" style=""><div class="loader"></div>');
                                    
                                    System.unpack(function()
                                    {
                                        // Hit when file has ben downloaded
                                        $("#upgrade-modal").html(
                                        '<h1>Transferring..</h1>' +
                                        '<div class="load5 loadimage" style=""><div class="loader"></div>');
                                        
                                        System.transfer(function()
                                        {
                                            $("#upgrade-modal").html(
                                                '<h1>Rebooting..</h1>' +
                                                '<div class="load5 loadimage" style=""><div class="loader"></div>');
                                            
                                            System.reboot(function()
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