<script type="text/javascript">
	require([_jsBase + 'main.js'], function(common)
   	{
        require(['jquery'], function($)
   	    {
            $(document).ready(function()
            {
                $("#timezone-picker option[value='{{$value}}']").prop('selected',true);
            });	
        });
	});
</script>

<div class="dropdown-section">
    <div class="dropdown">
        <div class="element">
            <label>{{$label}}:</label>
            <select id="timezone-picker" name="{{$file}}__{{$attribute}}">
                @include('data.timezones')
            </select>
        </div>
    </div>
</div>
