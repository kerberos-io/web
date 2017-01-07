<div class="image hullselection">

    <div id="map"></div>

    <?php
        $imageFile = App::make("Controllers\ImageController")->getLatestImage();

        if($imageFile)
        {
            $image = Image::make($imageFile['path']);
        }
        else
        {
            // fake an image
            $image = Image::canvas(800, 640);
        }
    ?>

    <script type="text/javascript">
    
        // Select a hull
        require([_jsBase + 'main.js'], function(common)
        {
            require(["app/controllers/hullselection"], function(hull)
            {
                hull.setElement($("#map"));
                hull.setImage("{{$imageFile['src']}}");
                hull.setImageSize("{{$image->width()}}","{{$image->height()}}");
                hull.setCoordinates("{{$value}}");
                hull.setName("{{$file."__".$attribute}}");
                hull.initialize();
            });
        });

    </script>
</div>