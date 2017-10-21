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
    <script src="{{URL::to('/')}}/js/vendor/mustache/mustache.js"></script>
    <!-- RequireJS -->
    <script src="{{URL::to('/')}}/js/vendor/requirejs/require.js"></script>
    <!-- Custom Fonts -->
    <link href="{{URL::to('/')}}/js/vendor/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Carousel -->
    <link href="{{URL::to('/')}}/js/vendor/owl.carousel/dist/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/js/vendor/owl.carousel/dist/assets/owl.theme.default.min.css" rel="stylesheet">
    <!-- Core CSS -->
    <link href="{{URL::to('/')}}/css/kerberos.min.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/js/vendor/csshake/dist/csshake.css" rel="stylesheet">
</head>
<body id="red" class="welcome">
    <div class="center" style="display: none;">
        <div class="content">
            <div class="circle">
                <div class="kerberos"></div>
            </div>
        </div>
        <form id="welcome">
            <h2>Welcome!</h2>
            <p>Please select your language.</p>
            <select id="language">
                <option value="bg">България</option>
                <option value="ca">Catalan</option>
                <option value="de">Deutsch</option>
                <option selected value="en">English</option>
                <option value="fr">Français</option>
                <option value="it">Italiano</option>
                <option value="nl">Nederlands</option>
                <option value="zh">中文</option>
                <!--<option value="pt">Português</option>-->
            </select>
            <div class="next">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </div>
        </form>
        <div id="introduction" style="display: none;"></div>
    </div>
    <script type="text/javascript">
        require([_jsBase + 'main.js'], function(common)
        {
            require(["app/controllers/welcome"], function(welcome)
            {
                welcome.initialize();
            });
        });
    </script>

    <footer id="branding">
         A product by<a class="logo" href="https://verstraeten.io" target="_blank"><i class="logo_verstraetenio"></i>verstraeten.io</a>
    </footer>
</body>
</html>
