/********************************************
*
*   Datepicker:  Initialize date picker with allowed dates
*               and mark the selected day.
*
**/

define(["jquery", "bootstrap", "eonasdan-bootstrap-datetimepicker"], function($, bootstrap)
{
    return {
        day: undefined,

        setDay: function(day)
        {
            this.day = day;
        },
        initialize: function()
        {
            var self = this;
            $.get(_baseUrl + "/api/v1/images/days", function(days)
            {
                $("#datetimepicker").datetimepicker({ 
                    useCurrent: false,
                    format: 'DD-MM-YYYY',
                    pickTime: false,
                    defaultDate: self.day,
                    enabledDates: days
                });
                
                $("#datetimepicker").on("dp.change",function(e)
                {
                    var myDate = $("#date-input").val();
                    window.location.href = _baseUrl + "/images/" + myDate;
                });
            });
        }
    };
});