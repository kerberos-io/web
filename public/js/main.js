require.config({
    baseUrl: _jsBase,
    urlArgs: "bust=20082021",
    shim: {
        'seiyria-bootstrap-slider': {
            deps: [
                'jquery',
                'bootstrap'
            ],
            exports: '$.fn.slider'
        },
        underscore: {
            exports: '_'
        },
        backbone: {
            deps: [
                'underscore',
                'jquery'
            ],
            exports: 'Backbone'
        },
        bootstrap: {
            deps: [
                'jquery'
            ],
            exports: 'bootstrap'
        },
        timepicker: {
            deps: [
                'bootstrap'
            ],
            exports: 'timepicker'
        },
        remodal: {
            deps: [
                'jquery'
            ],
            exports: 'remodal'
        },
        morrisjs: {
            deps: [
                'jquery',
                'raphael'
            ],
            exports: 'Morris'
        },
        fancybox: {
            deps: [
                'jquery'
            ]
        }
    },
    paths: {
        backbone: 'vendor/backbone/backbone',
        jquery: 'vendor/jquery/dist/jquery',
        moment: 'vendor/moment/moment',
        morrisjs: 'vendor/morrisjs/morris',
        raphael: 'vendor/raphael/raphael',
        bootstrap: 'vendor/bootstrap/dist/js/bootstrap',
        'eonasdan-bootstrap-datetimepicker': 'vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min',
        underscore: 'vendor/underscore/underscore',
        requirejs: 'vendor/requirejs/require',
        fancybox: 'vendor/fancybox/source/jquery.fancybox.pack',
        'seiyria-bootstrap-slider': 'vendor/seiyria-bootstrap-slider/js/bootstrap-slider',
        jellyfish: 'app/models/Jellyfish',
        Sequencer: 'app/models/Sequencer',
        timepicker: 'app/models/Timepicker',
        chartjs: 'vendor/chartjs/Chart',
        streamer: 'app/models/Streamer',
        heatmap: 'app/models/Heat',
        progressbar: 'vendor/progressbar.js/dist/progressbar.min',
        remodal: 'vendor/remodal/dist/jquery.remodal.min',
        photoswipe: 'vendor/photoswipe/dist/photoswipe.min',
        videojs: 'vendor/video.js/dist/video.min',
        videojsplaylist: 'vendor/videojs-playlist/dist/videojs-playlist',
        'photoswipe-ui': 'vendor/photoswipe/dist/photoswipe-ui-default.min'
    },
    packages: [

    ]
});