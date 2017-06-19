<?php
    //--------------
    // show multiple selected
    $instances = explode(",", $selected)
?>

<div class="dropdown">
    <div class="element">
        <label>{{$label}}</label>
        @foreach($instances as $i => $instance)
            <select name="{{$file}}__{{$attribute}}:{{$i}}">
                @foreach($children as $key => $child)
                    <option {{($instance==$key)?"selected":""}} value="{{$key}}">{{$key}}</option>
                @endforeach
            </select>
            @if($i > 0)
                <div class="icon delete-dropdown">
                    <i class="fa fa-trash-o"></i>
                </div>
            @endif
        @endforeach
    </div>
    <div class="icon open-section">
        <i class="fa fa-arrow-circle-down"></i>
    </div>
    @if(array_key_exists(1, $attributes) && $attributes[1]["value"] == "multiple")
        <div class="icon add-dropdown">
            <i class="fa fa-plus-circle"></i>
        </div>
    @endif
</div>
