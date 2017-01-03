@extends('template')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div id="settings" class="col-lg-6">
                    <div id="configuration">
                        <h2><i class="fa fa-industry"></i> Machinery</h2>
                        <label class="configuration-switch switch-light">
                            <input type="checkbox">
                            <span class="well">
                                <span>Basic</span>
                                <span>Advanced</span>
                                <a class="btn btn-primary"></a>
                            </span>
                        </label>
                    </div>

                    <div id="basic" style="display: {{($machinery['type'] === 'basic') ? 'block' : 'none'}}">

                        <div id="general" class="block">
                            <h4>General settings</h4>
                            <div class="name with-tooltip element">
                                <input type="text" placeholder="Name of camera" value=""/>
                                <span>
                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                    <span>Give an unique name to your camera. This is needed to split the activity afterwards.</span>
                                </span>
                            </div>

                            <div class="timezone with-tooltip element">
                               <select id="timezone-picker">
                                    @include('data.timezones')
                                </select>
                                <span>
                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                    <span>The timezone is used to convert timestamps to your local time.</span>
                                </span>
                            </div>
                        </div>

                        <div id="surveillance" class="block">
                            <h4>Surveillance</h4>

                        </div>

                    </div>

                    <div id="advanced" style="display: {{($machinery['type'] === 'advanced') ? 'block' : 'none'}}">
                        {{ Form::open(array('action' => 'Controllers\SettingsController@update')) }}
                            @include('settings_controls', array('settings' => $settings))
                            <div class="submit-form">
                                {{ Form::submit(Lang::get('settings.update')) }}
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>

                <div id="settings" class="col-lg-6">
                    <div id="configuration">
                        <h2><i class="fa fa-wrench"></i> {{Lang::get('settings.configuration')}}</h2>

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
            require(["app/controllers/settings"]);

            require(["app/controllers/toggleSettings"], function(toggleSettings)
            {
                toggleSettings.initialize();
                
                $(".configuration-switch input[type='checkbox']").click(function()
                {
                    var checked = $(this).attr('checked');
                    toggleSettings.setType((checked == undefined) ? 'advanced' : 'basic');
                });
            });
        });
    </script>
@stop