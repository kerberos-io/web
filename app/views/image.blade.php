@extends('template')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Images: overview -->
            <div class="row">
                <div class="col-lg-12">
                    <div id="timeslider-wrapper">
                    
                        <input id="timer-slider" type="text" 
                        data-slider-id='timeSlider'  data-slider-min="0" data-slider-max="{{$lastHourOfDay}}" 
                        data-slider-step="1" data-slider-value="{{$lastHourOfDay}}"/>

                    </div>

                    <div id="loading-image-view" class="load4" style="padding:50px 0;">
                        <div class="loader"></div>
                    </div>

                    <!-- The Modal -->
                    <div id="myModal" class="modal">
                        <!-- Modal content -->
                        <div class="modal-center">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <video id="sequence" class="video-js" controls preload="auto" width="500" height="500"></video>
                            </div>
                        </div>
                    </div>

                    @include('photoswipe')
                    
                    <div id="images-overview"></div>
                    <script type="text/javascript">
                        require([_jsBase + 'main.js'], function(common)
                        {
                            require(["app/controllers/images"], function(imageController)
                            {
                                imageController.setDay("{{$selectedDay}}");
                                imageController.setStartTime("{{$lastHourOfDay}}");
                                imageController.initialize();
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
    <!-- CSS loader, shown when an url is pasted -->
    <div class="start-loading">
        <div class="scroll-down"><i class="fa fa-repeat"></i> Load more..</div>
        <div id="load-more-images" class="load4" style="display:none;">
            <div class="loader"></div>
        </div>
    </div>
@stop