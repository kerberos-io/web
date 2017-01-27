@extends('template')

@section('content')

    @if(!$settings['cloud']['dropdown']['S3']['children']['bucket']['value'])
    <div class="alert-update alert alert-warning" role="alert"><a href="https://cloud.kerberos.io/" target="_blank">{{Lang::get('settings.purchase')}}</a></div>
    @endif
    
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div id="machinery-settings" class="col-lg-6">
                    <div id="configuration">
                        <h2><i class="fa fa-industry"></i> Machinery</h2>
                        <label class="configuration-switch switch-light">
                            <input type="checkbox">
                            <span class="well">
                                <span>{{Lang::get('settings.basic')}}</span>
                                <span>{{Lang::get('settings.advanced')}}</span>
                                <a class="btn btn-primary"></a>
                            </span>
                        </label>
                    </div>

                    {{ Form::open(array('action' => 'Controllers\SettingsController@update')) }}

                        <!-- Basic View -->
                        @include('settings.basic', ['kerberos' => $kerberos])

                        <!-- Advanced view -->
                        @include('settings.advanced', ['kerberos' => $kerberos, 'settings' => $settings])

                    {{ Form::close() }}
                </div>

                <div id="web-settings" class="col-lg-6">
                    <div id="configuration">
                        <h2><i class="fa fa-eye"></i> Web</h2>
                        {{ Form::open(array('action' => 'Controllers\SettingsController@updateWeb')) }}
                            <div class="content">
                                <div id="loading-image-view" class="load4" style="padding:50px 0;">
                                    <div class="loader"></div>
                                </div>
                            </div>
                        {{ Form::close() }}
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
            require(["app/controllers/settings_advanced"], function(SettingsAdvanced){});

            require(["app/controllers/toggleSettings", "app/controllers/settings_basic", "app/controllers/settings_web"], function(toggleSettings, SettingsBasic, SettingsWeb)
            {
                $.get( _baseUrl + "/api/v1/translate/settings", function(translation)
                {
                    SettingsBasic.initialize(translation);
                    SettingsWeb.initialize("{{$kerberos['radius']}}", translation);
                });

                toggleSettings.initialize();
                
                $(".configuration-switch input[type='checkbox']").click(function()
                {
                    // toggle settings
                    var checked = $(this).attr('checked');
                    toggleSettings.setType((checked == undefined) ? 'advanced' : 'basic');
                });
            });

            require(["app/controllers/hullselection", "app/controllers/twolines"], function(hull, twolines)
            {
                hull.setElement($(".hullselection .map"));
                twolines.setElement($(".twolines .map"));

                hull.getLatestImage(function(image)
                {
                    hull.setImage(image.src);
                    hull.setImageSize(image.width, image.height);
                    hull.setCoordinates($(".hullselection .coordinates").val());
                    hull.setName($(".hullselection .name").val());
                    hull.initialize();

                    twolines.setImage(image.src);
                    twolines.setImageSize(image.width, image.height);
                    twolines.setCoordinates($(".twolines .coordinates").val());
                    twolines.setName($(".twolines .name").val());
                    twolines.initialize();
                });
            });
        });
    </script>
@stop