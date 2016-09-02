<div class="image twolines">

    <div id="map"></div>

    <?php
        $src = App::make("Controllers\ImageController")->getLatestImage();

        if($src != "")
        {
            $image = Image::make($src);
        }
        else
        {
            // fake an image
            $image = Image::canvas(800, 640);
        }
    ?>

    <script type="text/javascript">

        // Select two lines
        require([_jsBase + 'main.js'], function(common)
        {
            require(["app/controllers/twolines"], function(twolines)
            {
                twolines.setElement($(".twolines #map"));
                twolines.setImage("{{$src}}");
                twolines.setImageSize("{{$image->width()}}","{{$image->height()}}");
                twolines.setCoordinates("{{$value}}");
                twolines.setName("{{$file."__".$attribute}}");
                twolines.initialize();
            });
        });

    </script>
</div>