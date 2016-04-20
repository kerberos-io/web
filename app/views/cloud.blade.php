@extends('template')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div id="cloud" class="col-lg-12">
                    <h2><i class="fa fa-cloud"></i> {{Lang::get('cloud.cloud')}}</h2>
                    
                    <div class="description">{{Lang::get('cloud.description')}}.</div>
                    
                    {{ Form::open(array('action' => 'Controllers\SettingsController@update')) }}
                        @include('settings_controls', array('settings' => $settings))
                        <div class="submit-form">
                            {{ Form::submit(Lang::get('cloud.update')) }}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop
