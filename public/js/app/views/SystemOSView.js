/*******************
*  SystemOSView
****/

define(["underscore", "backbone", "app/views/BaseView", "progressbar"], 
    function (_, Backbone, BaseView, ProgressBar)
{ 
    var SystemOSView = BaseView.extend(
    {
        el : '#system .view',
        view : 'system-os',

        initialize: function(translation, system)
        {
            this.model = {};
            this.model.translation = translation;
            this.system = system;
        },
        fetchData: function(callback)
        {
            $.get( _baseUrl + "/api/v1/system/os", function(data)
            {
                callback(data);
            });
        },
        render: function(data)
        {
            this.model.os = data;
            this.$el.html(this.template(this.model));

            // ------------------------
            // Check disk size, if full

            if(this.model.os.diskAlmostFull)
            {
                $("#diskFull").show();
            }

            // -----------------
            // Bind click events

            var self = this;
            this.$el.find("#reboot").click(function()
            {   
                var options = {
                    hashTracking: false,
                    closeOnAnyClick: false, 
                    closeOnEscape: false
                };

                var modal = $('[data-remodal-id=shutdown]').remodal(options);
                modal.open();

                $("#shutdown-modal").html(
                        "<h1>" + self.model.translation.rebooting + "..</h1>" +
                        "<div id='count-down'></div>");

                var waitingTime = 60000;

                var countDown = new ProgressBar.Circle('#count-down', {
                    color: '#943633',
                    strokeWidth: 3,
                    trailWidth: 1,
                    duration: waitingTime,
                    text: {
                        value: '60'
                    },
                    step: function(state, bar)
                    {
                        bar.setText(60 - (bar.value() * 60).toFixed(0));
                    }
                });

                countDown.animate(1);

                setInterval(function() { window.location.reload() }, waitingTime);                      

                self.system.rebooting(function(){});
            });

            this.$el.find("#shutdown").click(function()
            {
                var options = {
                    hashTracking: false,
                    closeOnAnyClick: false, 
                    closeOnEscape: false
                };
                var modal = $('[data-remodal-id=shutdown]').remodal(options);
                modal.open();

                $("#shutdown-modal").html(
                        "<h1>" + self.model.translation.shuttingdown + "..</h1>" +
                        "<div id='count-down'></div>");

                var waitingTime = 60000;

                var countDown = new ProgressBar.Circle('#count-down', {
                    color: '#943633',
                    strokeWidth: 3,
                    trailWidth: 1,
                    duration: waitingTime,
                    text: {
                        value: '60'
                    },
                    step: function(state, bar)
                    {
                        bar.setText(60 - (bar.value() * 60).toFixed(0));
                    }
                });

                countDown.animate(1);

                setInterval(function() { window.location.reload() }, waitingTime); 

                self.system.shuttingdown(function(){});
            });
            return this;
        }
    });

    return SystemOSView;
});