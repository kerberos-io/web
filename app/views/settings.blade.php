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

                    {{ Form::open(array('action' => 'Controllers\SettingsController@update')) }}

                        <!-- Basic View -->
                        @include('settings.basic', ['machinery' => $machinery])

                        <!-- Advanced view -->
                        @include('settings.advanced', ['machinery' => $machinery, 'settings' => $settings])

                    {{ Form::close() }}
                </div>

                <div id="settings" class="col-lg-6">
                    <div id="configuration">
                        <h2><i class="fa fa-wrench"></i> Web</h2>

                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

     <?php
        $src = App::make("Controllers\ImageController")->getLatestImage();

        if($src != "")
        {
            $image = Image::make($src);
        }
        else
        {
            // fake an image
            $image = Image::canvas(600, 480);
        }
    ?>
    
    <script type="text/javascript">
        require([_jsBase + 'main.js'], function(common)
        {
            require(["app/controllers/settings_advanced"]);

            require(["app/controllers/toggleSettings", "app/controllers/settings_basic"], function(toggleSettings, SettingsBasic)
            {
                SettingsBasic.setImage({
                    src: "{{$src}}",
                    width: {{$image->width()}},
                    height: {{$image->height()}}
                });
                SettingsBasic.initialize();

                toggleSettings.initialize();
                
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