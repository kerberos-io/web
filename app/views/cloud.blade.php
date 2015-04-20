@extends('template')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div id="cloud" class="col-lg-12">
                    <h2><i class="fa fa-cloud"></i> Cloud</h2>
                    
                    <div class="description">Kerberos offers a <b>cloud application service</b>, to centralize and follow up multiple Kerberos instances. To sync the events of this
                    instance to our cloud application, you first will need to <a href="https://cloud.kerberos.io">register an account</a> and subscribe to a plan. When you're subscribed succesfully, 
                    you will receive some credentials that you can fill in the fields below. Once you've entered <b>your credentials</b> your events will be send to the cloud application.</div>
                    
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
@stop
