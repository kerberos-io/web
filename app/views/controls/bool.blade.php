<div class="text">
    <label>{{$label}}:</label>
    <input id="{{$file}}__{{$attribute}}" type="checkbox" {{($value=="true")?"checked":""}}/>
    <input type="hidden" name="{{$file}}__{{$attribute}}" value="{{$value}}"/>
</div>

<script type="text/javascript">
    // Select a hull
    require([_jsBase + 'main.js'], function(common)
    {
        require(["jquery"], function($)
        {
            $("#{{$file}}__{{$attribute}}").change(function(){
                $(this).next().val($(this).prop("checked"));
            });
        });
    });

</script>