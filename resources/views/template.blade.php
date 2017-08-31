<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title>Kerberos.io</title>
    <meta name="description" content="Video surveillance made easy. Kerberos.io is a free video surveillance solution, which works with any camera and on every Linux based machine. You can deploy a fully configured video surveillance system within a few minutes on the environment you prefer: Raspberry Pi, Docker, etc.">
    <meta name="author" content="Verstraeten.io">
    <meta name="robots" content="none" />

    <link rel="icon" type="image/png" href="{{URL::to('/')}}/images/favicon.ico" />

    <!-- Mustachejs -->
    <script src="{{URL::to('/')}}/js/vendor/mustache/mustache.js"></script>
    <!-- Custom Fonts -->
    <link href="{{URL::to('/')}}/js/vendor/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- RequireJS -->
    <script src="{{URL::to('/')}}/js/vendor/requirejs/require.js"></script>
    <!-- Toggle -->
    <link href="{{URL::to('/')}}/js/vendor/css-toggle-switch/dist/toggle-switch.css" rel="stylesheet">
    <!-- Photoswipe -->
    <link href="{{URL::to('/')}}/js/vendor/photoswipe/dist/photoswipe.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/js/vendor/photoswipe/dist/default-skin/default-skin.css" rel="stylesheet">
    <!-- VideoJS -->
    <link href="{{URL::to('/')}}/js/vendor/video.js/dist/video-js.min.css" rel="stylesheet">
    <!-- Carousel -->
    <link href="{{URL::to('/')}}/js/vendor/owl.carousel/dist/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/js/vendor/owl.carousel/dist/assets/owl.theme.default.min.css" rel="stylesheet">
    <!-- Core CSS -->
    <link href="{{URL::to('/')}}/css/kerberos.min.css" rel="stylesheet">

    <!-- IE css -->
    <link href="{{URL::to('/')}}/css/ie.css" rel="stylesheet"/>

    <!-- Globals variables, that are used in the application -->
    <script type="text/javascript">
        var _baseUrl = "{{URL::to('/')}}";
        var _jsBase = _baseUrl + "/js/";
    </script>
</head>
<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="signout" href="{{URL::to('/')}}/logout">
                    <i class="fa fa-sign-out"></i>
                </a>
                <label style="width:60px; padding-top: 10px" class="machinery-switch toggle-mobile switch-light">
                    <input type="checkbox" style="outline: none;">
                    <span class="well" style="margin:0;background-color:#fff; color: #fff;">
                        <span>{{Lang::get('general.off')}}</span>
                        <span>{{Lang::get('general.on')}}</span>
                        <a class="btn btn-primary" style="background-color: #943633; border-color: #943633"></a>
                    </span>
                </label>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                 <a class="settings" href="{{URL::to('/settings')}}">
                    <i class="fa fa-wrench"></i>
                </a>
                <a class="system" href="{{URL::to('/')}}/system">
                    <i class="fa fa-heartbeat"></i>
                </a>
                <a class="profile update-profile" href="#">
                    <i class="fa fa-fw fa-user"></i>
                </a>
                <div class="circle">
                    <a href="{{URL::to('/')}}">
                        <div class="kerberos"></div>
                    </a>
                </div>
                <a class="navbar-brand" href="{{URL::to('/')}}">
                    <h1>KERBEROS.IO</h1>
                    <span class="camera-name"> > {{$cameraName}}</span>
                </a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="active">
                    <a href="{{URL::to('/')}}"><i class="fa fa-area-chart"></i> {{Lang::get('general.dashboard')}}</a>
                </li>
                <li>
                    <a href="{{URL::to('/system')}}"><i class="fa fa-heartbeat"></i> {{Lang::get('general.system')}}</a>
                </li>
                @if(Config::get('app.config') != '')
                <li>
                    <a href="{{URL::to('/settings')}}"><i class="fa fa-wrench"></i> {{Lang::get('general.configuration')}}</a>
                </li>
                <!--<li>
                    <a href="{{URL::to('/cloud')}}"><i class="fa fa-cloud"></i> {{Lang::get('general.cloud')}}</a>
                </li>-->
                @endif

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::user()->username}} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" class="update-profile"><i class="fa fa-fw fa-pencil"></i> {{Lang::get('general.update-profile')}}</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/logout')}}"><i class="fa fa-fw fa-power-off"></i> {{Lang::get('general.logout')}}</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <label class="machinery-switch switch-light">
                        <input type="checkbox">
                        <span class="well">
                            <span>{{Lang::get('general.off')}}</span>
                            <span>{{Lang::get('general.on')}}</span>
                            <a class="btn btn-primary"></a>
                        </span>
                    </label>
                </li>
            </ul>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <script type="text/javascript">
                require([_jsBase + 'main.js'], function(common)
                {
                    require(["app/controllers/datepicker"], function(datepicker)
                    {
                        datepicker.setDay("{{(isset($selectedDay))?$selectedDay:'null'}}");
                        datepicker.initialize();
                    });

                    require(["app/controllers/toggleMachinery"], function(toggleMachinery)
                    {
                        toggleMachinery.initialize();

                        $(".machinery-switch input[type='checkbox']").click(function()
                        {
                            var checked = $(this).attr('checked');
                            toggleMachinery.setStatus((checked === undefined));
                        });
                    });

                    require(["app/controllers/updateProfile", "app/controllers/Cache"], function(updateProfile, Cache)
                    {
                        Cache( _baseUrl + "/api/v1/translate/updateprofile").then(function(translation)
                        {
                            updateProfile.initialize(translation);

                            $(".update-profile").click(function()
                            {
                                updateProfile.open();
                            });
                        });
                    });
                });
            </script>

            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="datepicker">
                        <div class="form-group">
                            <div class='input-group date' id='datetimepicker'>
                                <input id="date-input" type='text' class="form-control" />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </li>
                    <!-- show latest days -->
                    @foreach($days as $day)
                        <li {{(isset($selectedDay) && $selectedDay == $day)?"class=active":''}}>
                            <a href="{{URL::to('/').'/images/'.$day}}">
                                <i class="fa fa-calendar"></i>&nbsp; {{Carbon\Carbon::parse($day)->format('jS \\of F Y') }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="new-release" style="display:none;" class="alert-update alert alert-warning" role="alert"><a href="{{URL::to('/').'/system'}}">{{Lang::get('system.newVersion')}}</a></div>
        <div id="disabled-machinery" style="display:{{$isActive}};" class="alert-update alert alert-danger" role="alert">{{Lang::get('system.disabled')}}</div>

        <script type="text/javascript">
            require([_jsBase + 'main.js'], function(common)
            {
                require(["app/controllers/releases"], function(Releases)
                {
                    Releases.highlightIfNewRelease();
                });
            });
        </script>

        @yield('content')
    </div>
    <div id="update-profile-modal" data-remodal-id="update-profile">
        <div id="loading-image-view" class="load4" style="padding:50px 0;">
            <div class="loader"></div>
        </div>
    </div>
    <!-- /#wrapper -->
</body>
</html>
