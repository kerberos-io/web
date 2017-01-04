<div id="advanced" style="display: {{($machinery['type'] === 'advanced') ? 'block' : 'none'}}">
                            
        @include('settings_controls', array('settings' => $settings))
        <div class="submit-form">
            {{ Form::submit(Lang::get('settings.update')) }}
        </div>
</div>