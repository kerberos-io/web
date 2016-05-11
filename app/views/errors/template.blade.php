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
    <!-- Core CSS -->
    <link href="{{URL::to('/')}}/css/kerberos.min.css" rel="stylesheet">
    
    <!-- Globals variables, that are used in the application -->
    <script type="text/javascript">
        var _baseUrl = "{{URL::to('/')}}";
        var _jsBase = _baseUrl + "/js/"; 
    </script>
</head>
<body id="red" class="login">
    <div class="center">
        <div class="content">
            <div class="circle">
                <div class="kerberos"></div>
            </div>
        </div>
        <div id="error-message">
            @yield('content')
        </div>
    </div>
</body>
</html>
