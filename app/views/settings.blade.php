@extends('template')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div id="settings" class="col-lg-12">
                    <h2><i class="fa fa-list"></i> Settings</h2>
                    {{ Form::open(array('action' => 'Controllers\SettingsController@update')) }}
                        @include('settings_controls', array('settings' => $settings))
                        <div class="submit-form">
                            {{ Form::submit('update') }}
                        </div>
                    {{ Form::close() }}
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
        });
    </script>
@stop