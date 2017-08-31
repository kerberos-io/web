require.config({
    baseUrl: _jsBase,
    urlArgs: "bust=20170127",
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
        carousel: {
            deps: [
                'jquery'
            ]
        },
        videojsplaylist: {
            deps: [
                'add-video-js-in-global-scope'
            ]
        },
        videojsplaylistui: {
            deps: [
                'videojsplaylist'
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
        'seiyria-bootstrap-slider': 'vendor/seiyria-bootstrap-slider/dist/bootstrap-slider.min',
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
        videojsplaylistui: 'app/models/PlaylistUI',
        carousel: 'vendor/owl.carousel/dist/owl.carousel.min',
        'photoswipe-ui': 'vendor/photoswipe/dist/photoswipe-ui-default.min'
    },
    packages: [

    ]
});
