@extends('template')

@section('content')

    <div id="diskFull" style="display:none">
        <div class="alert-update alert alert-danger" role="alert">{!! Lang::get('system.diskAlmostFull') !!}</div>
    </div>

    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">

                <div id="system" class="col-lg-6">
                    <h2><i class="fa fa-desktop"></i> {{Lang::get('system.system')}}</h2>
                    <div class="view">
                        <div id="loading-image-view" class="load4" style="padding:50px 0;">
                            <div class="loader"></div>
                        </div>
                    </div>
                    <div id="shutdown-modal" data-remodal-id="shutdown">
                        <div class="modal-body"></div>
                    </div>
                </div>

                <div id="kerberos" class="col-lg-6">
                    <h2><i class="fa fa-user-secret"></i> Kerberos.io</h2>
                    <div class="view">
                        <div id="loading-image-view" class="load4" style="padding:50px 0;">
                            <div class="loader"></div>
                        </div>
                    </div>
                </div>

                <div id="news" class="col-lg-6">
                    <h2><i class="fa fa-newspaper-o"></i> News</h2>
                    <div class="view">
                        <div id="loading-image-view" class="load4" style="padding:50px 0;">
                            <div class="loader"></div>
                        </div>
                    </div>
                </div>

                <div id="kios" class="col-lg-6"></div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <script type="text/javascript">
        require([_jsBase + 'main.js'], function(common)
        {
            require(["app/controllers/system", "remodal", "progressbar", "app/controllers/Cache"], function(System, remodal, ProgressBar, Cache)
            {
                Cache(_baseUrl + "/api/v1/translate/system").then(function (translation)
                {
                    System.initialize(translation);
                });
            });
        });
    </script>
@stop
