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
    <!-- RequireJS -->
    <script src="{{URL::to('/')}}/js/vendor/requirejs/require.js"></script>
    <!-- Core CSS -->
    <link href="{{URL::to('/')}}/css/kerberos.min.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/js/vendor/csshake/dist/csshake.css" rel="stylesheet">
</head>
<body id="red" class="login">
    <div class="center" style="display: none;">
        <div class="content">
            <div class="circle">
                <div class="kerberos"></div>
            </div>
        </div>
        <form id="login">
            <input type="text" id="username" placeholder="username" name="username"/>
            <input type="password" id="password" placeholder="password" name="password"/>
            <input type="submit" id="submit" value="Login"/>
        </form>
    </div>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <script type="text/javascript">
        require([_jsBase + 'main.js'], function(common)
        {
            require(["app/controllers/login"], function(login)
            {
                login.setForm($("#login"));
                login.setCredentials($("#username"), $("#password"));
                login.setMessageBag($("#messages"));
                login.initialize();
            });
        });
    </script>

    <footer id="branding">
         A product by<a class="logo" href="https://verstraeten.io" target="_blank"><i class="logo_verstraetenio"></i>verstraeten.io</a>
    </footer>
</body>
</html>
