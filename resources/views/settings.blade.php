@extends('template')

@section('content')

    @if(!$settings['cloud']['dropdown']['S3']['children']['bucket']['value'])
    <div class="alert-update alert alert-warning" role="alert"><a href="https://cloud.kerberos.io/" target="_blank">{!! Lang::get('settings.purchase') !!}</a></div>
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

                    {{ Form::open(array('action' => 'SettingsController@update')) }}

                        <!-- Basic View -->
                        @include('settings.basic', ['kerberos' => $kerberos])

                        <!-- Advanced view -->
                        @include('settings.advanced', ['kerberos' => $kerberos, 'settings' => $settings])

                    {{ Form::close() }}
                </div>

                <div id="web-settings" class="col-lg-6">
                    @if($kios)
                        <div id="kios-configuration">
                            <h2><i class="fa fa-server"></i> KiOS</h2>
                            <div class="kios-content content">
                                <div id="loading-image-view" class="load4" style="padding:50px 0;">
                                    <div class="loader"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="configuration">
                        <h2><i class="fa fa-eye"></i> Web</h2>
                        {{ Form::open(array('action' => 'SettingsController@updateWeb')) }}
                            <div class="web-content content">
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

            require(["app/controllers/toggleSettings", "app/controllers/settings_basic", "app/controllers/settings_web", "app/controllers/settings_kios", "app/controllers/Cache"], function(toggleSettings, SettingsBasic, SettingsWeb, SettingsKiOS, Cache)
            {
                // First load advanced settings.
                toggleSettings.initialize(function()
                {
                    Cache(_baseUrl + "/api/v1/translate/settings").then(function(translation)
                    {
                        SettingsKiOS.initialize("{{$kios['autoremoval']}}", "{{$kios['forcenetwork']}}", translation);
                        SettingsWeb.initialize("{{$kerberos['radius']}}", translation);
                        SettingsBasic.initialize(translation);
                    });
                });

                $(".configuration-switch input[type='checkbox']").click(function()
                {
                    // toggle settings
                    var checked = $(this).attr('checked');
                    toggleSettings.setType((checked == undefined) ? 'advanced' : 'basic');
                });
            });
        });
    </script>
@stop
