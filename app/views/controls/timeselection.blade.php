<div id="timeselection">
	<?php
		$times = explode('-', $value);
	?>
	@foreach([
        Lang::get('general.monday'),
        Lang::get('general.tuesday'),
        Lang::get('general.wednesday'),
        Lang::get('general.thursday'),
        Lang::get('general.friday'),
        Lang::get('general.saturday'),
        Lang::get('general.sunday')
    ] as $key => $day)
		@if(count($times) > $key)
			<?php
				$time = explode(",", $times[$key]);
			?>
			<div class="day">
			    <label>{{$day}}:</label>
			    <input type="checkbox" class="enabled" {{(strlen($times[$key])>3)?"checked":""}}/>
			    <i class="fa fa-clock-o"></i>
			   	<div class="col-xs-3">
				   	<input class="timepicker form-control" type="text" value="{{($time[0]=='0')?'0':$time[0]}}" {{($time[0]=="0")?"disabled='true'":""}}/>
				</div>
				<i class="fa fa-clock-o"></i>
				<div class="col-xs-3">
				   	<input class="timepicker form-control" type="text" value="{{($time[1]=='0')?'0':$time[1]}}" {{($time[1]=="0")?"disabled='true'":""}}/>
				</div>
			</div>
		@endif
	@endforeach
</div>
<input id="times-list" type="hidden" name="{{$file}}__{{$attribute}}" value="{{$value}}"/>

<script type="text/javascript">
	require([_jsBase + 'main.js'], function(common)
   	{
		require(["app/controllers/timepicker"]);
	});
</script>