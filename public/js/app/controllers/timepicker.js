/**
*   Timepicker:  On the settings page a user can select a time range
**/

require(["timepicker"], function(timepicker)
{   
    $("#timeselection .timepicker").timepicker({
        showMeridian: false,
        template: false,
        minuteStep: 1
    }).on('changeTime.timepicker', changedTimepicker);

    $("#timeselection input[type='checkbox']").change(function()
    {
        var checked = $(this).prop("checked");
        var inputs = $(this).siblings("div").find("input");
        if(checked)
        {
            inputs.attr("disabled", false);
            inputs.val("12:00");
        }
        else
        {
            inputs.attr("disabled", true);
            inputs.val("");
        }
        changedTimepicker();
    });

    function changedTimepicker()
    {
        var times = "";
        $.each($("#timeselection .timepicker"), function(key, value)
        {
            value = $(value).val();
            times += (value=="")?"0":value;

            if(key%2 == 1)
            {
                times += "-";
            }
            else
            {
                times += ",";
            }
        });

        $("#times-list").val(times.slice(0,-1));
    }
});