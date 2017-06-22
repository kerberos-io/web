@foreach($settings as $key => $item)

    {{-- Render the correct input element according the type attribute --}}
    @if(isset($item["attributes"]) && count($item["attributes"]) > 0 && $item["attributes"][0]["key"] == "type")

        @include("controls." . $item["attributes"][0]["value"], ["label" => $key, "file" => $item["file"], "attribute" => $item["attribute"], "value" => $item["value"]])

    {{-- Render a dropdown list, with name fields of external file --}}
    @elseif(array_key_exists("dropdown", $item) && is_array($item["dropdown"]) && count($item["dropdown"]) > 0)
        <div class="dropdown-section">
        @include("controls.dropdown", ["label" => $key, "children" => $item["dropdown"], "file" => $item["file"], "attribute" => $item["attribute"], "attributes" => $item["attributes"], "selected" => $item["value"]])

        {{-- A dropdown has one or more children --}}
        {{-- Recursive call to this view, render children --}}
        <div class="section">
        @foreach($item["dropdown"] as $key => $something)

            <div class="sub" id="{{$key}}" {{(strpos($item["value"], $key) === false) ? "style=display:none;" : ''}}>
                <h2>{{$key}}</h2>
                @include('settings_controls', array('settings' => $something["children"]))
            </div>

        @endforeach
        </div>
        </div>

    {{-- If a wrapper item --}}
    @elseif(is_array($item))

        <fieldlist class="wrapper">
            <legend>{{$key}}</legend>
            @include('settings_controls', array('settings' => $item["children"]))
        </fieldset>

    @endif

@endforeach
