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

                    <div id="video-modal" data-remodal-id="video">
                        <section class="main-preview-player">
                          <video id="sequence" class="video-js vjs-fluid" controls preload="auto" crossorigin="anonymous">
                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                          </video>
                          <div class="playlist-container preview-player-dimensions vjs-fluid">
                            <ol class="vjs-playlist"></ol>
                          </div>
                        </section>
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