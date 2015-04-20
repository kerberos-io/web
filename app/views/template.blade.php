<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="homesecurity webinterface">
    <meta name="author" content="Cédric Verstraeten">
    
    <link rel="icon" type="image/png" href="{{URL::to('/')}}/images/favicon.ico" />

    <title>kerberos.io - Video Surveillance</title>

    <!-- Globals variables, that are used in the application -->
    <script type="text/javascript">
        var _baseUrl = "{{URL::to('/')}}";
        var _jsBase = _baseUrl + "/js/";
    </script>

    <!-- Mustachejs -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/mustache.js/0.7.0/mustache.min.js"></script>
    <!-- Custom Fonts -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- RequireJS -->
    <script src="{{URL::to('/')}}/js/vendor/requirejs/require.js"></script>
    <!-- Core CSS -->
    <link href="{{URL::to('/')}}/css/kerberos.min.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="signout" href="{{URL::to('/')}}/logout">
                    <i class="fa fa-sign-out"></i>
                </a>
                <div class="circle">
                    <div class="kerberos"></div>
                </div>
                <a class="navbar-brand" href="{{URL::to('/')}}"><h1>KERBEROS.IO</h1></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="active">
                    <a href="{{URL::to('/')}}"><i class="fa fa-area-chart"></i> Dashboard</a>
                </li>

                @if(Config::get('app.config') != '')
                <li>
                    <a href="{{URL::to('/settings')}}"><i class="fa fa-list"></i> Settings</a>
                </li>
                <li>
                    <a href="{{URL::to('/cloud')}}"><i class="fa fa-cloud"></i> Cloud</a>
                </li>
                @endif

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::user()->username}} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{URL::to('/logout')}}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
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
                        <li {{(isset($selectedDay) && $selectedDay == $day)?"class='active'":''}}>
                            <a href="{{URL::to('/').'/images/'.$day}}">
                                <i class="fa fa-calendar"></i>&nbsp; {{Carbon\Carbon::parse($day)->format('jS \\of F Y') }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        @yield('content')
    </div>
    <!-- /#wrapper -->
</body>
</html>
