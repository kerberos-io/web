<div id="basic" style="display: {{($machinery['type'] === 'basic') ? 'block' : 'none'}}"></div>

<script type="text/javascript">
    require([_jsBase + 'main.js'], function(common)
    {
        require(["app/controllers/settings_basic"], function(SettingsBasic)
        {
            SettingsBasic.initialize();
        });
    });
</script>