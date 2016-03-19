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
                    <div style="display: table" class="alert alert-info" role="alert">Nice, a new version of Kerberos.io is available! Click here to update..</div>
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
                $("#clean").click(function()
                {
                    System.clean();
                });
            });
        });
    </script>
@stop