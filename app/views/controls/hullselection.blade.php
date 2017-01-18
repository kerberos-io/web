<div class="image hullselection">

    <div id="map" style="position: relative;"></div>

    <script type="text/javascript">
    
        // Select a hull
        require([_jsBase + 'main.js'], function(common)
        {
            require(["app/controllers/hullselection"], function(hull)
            {
                hull.setElement($("#map"));
                hull.getLatestImage(function(image)
                {
                    hull.setImage(image.src);
                    hull.setImageSize(image.width, image.height);
                    hull.setCoordinates("{{$value}}");
                    hull.setName("{{$file."__".$attribute}}");
                    hull.initialize();
                });
            });
        });

    </script>
</div>