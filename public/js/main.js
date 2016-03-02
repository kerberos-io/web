require.config({
    baseUrl: _jsBase,
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
        heatmap: 'vendor/heatmap.js-amd/build/heatmap'
    },
    packages: [

    ]
});