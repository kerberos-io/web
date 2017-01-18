<div class="image twolines">

    <div class="map" style="position: relative;"></div>

    <script type="text/javascript">

        // Select two lines
        require([_jsBase + 'main.js'], function(common)
        {
            require(["app/controllers/twolines"], function(twolines)
            {
                twolines.setElement($(".twolines .map"));
                twolines.getLatestImage(function(image)
                { 
                    twolines.setImage(image.src);
                    twolines.setImageSize(image.width, image.height);
                    twolines.setCoordinates("{{$value}}");
                    twolines.setName("{{$file."__".$attribute}}");
                    twolines.initialize();
                });
            });
        });

    </script>
</div>