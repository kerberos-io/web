<div class="image hullselection">

    <div id="map" style="position: relative;"></div>

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
    
        // Select a hull
        require([_jsBase + 'main.js'], function(common)
        {
            require(["app/controllers/hullselection"], function(hull)
            {
                hull.setElement($("#map"));
                hull.setImage("{{$src}}");
                hull.setImageSize("{{$image->width()}}","{{$image->height()}}");
                hull.setCoordinates("{{$value}}");
                hull.setName("{{$file."__".$attribute}}");
                hull.initialize();
            });
        });

    </script>
</div>