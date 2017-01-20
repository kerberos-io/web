/**********************
*  USB Camera View
****/

define(["underscore", "jquery", "backbone", "app/views/BaseView", "seiyria-bootstrap-slider", "app/controllers/hullselection"],
    function (_, $, Backbone, BaseView, Slider, hull)
{ 
    var SettingsBasicMotionView = BaseView.extend(
    {
        el : '<div>',
        view : 'settings/settings-basic-motion',
        model: undefined,
        image: undefined,
        devices: undefined,
        events: {
            'click .rotate .image':'changeRotation',
            'change .tgl': 'toggleIoDevice'
        },

        initialize: function(model, image)
        {
            this.model = model;
            this.image = image;
        },
        createSlider: function()
        {
            var self = this;
            self.$el.find('.slider-delay, .slider-fps, .video-fps, .video-record-seconds').slider({});
        },
        createCarousel: function()
        {
            var self = this;
            this.carousel = self.$el.find('.owl-carousel');
            this.carousel.owlCarousel({
                items: 1,
                touchDrag: false,
                mouseDrag: false,
                nav: true,
                navText: [
                    "<i class='fa fa-arrow-left' aria-hidden='true'></i>",
                    "<i class='fa fa-arrow-right' aria-hidden='true'></i>"
                ],
            });
        },
        setDevices: function()
        {
            var self = this;
            _.each(this.model.devices, function(device, key)
            {
                if(device.enabled)
                {
                    // Enable option in basic view
                    self.$el.find("#" + key).prop('checked', true);
                    self.$el.find("#" + key).parent().parent().find('.content').show();
                }
            })
        },
        setColor: function()
        {
            if(this.model.devices.disk.markWithTimestamp === "true")
            {
                this.$el.find("#timestamp-color").val(this.model.devices.disk.colorTimestamp);
            }
        },
        setRegionSelector: function()
        {
            hull.setElement(this.$el.find("#region-selector"));
            hull.getLatestImage(function(image)
            {
                hull.setImage(image.src);
                hull.setImageSize(image.width, image.height);
                hull.setCoordinates($("input[name='expositor__Hull__region']").val());
                hull.setName("motion-hullselection");
                hull.initialize();
            });

            var self = this;
            this.carousel.on('changed.owl.carousel', function(event)
            {
                var section = event.item.index;
                self.$el.find("#step div.title").html($(self.$el.find(".part").get(section)).attr('description'));
                self.$el.find("#step span.info").html($(self.$el.find(".part").get(section)).attr('info'));
                $(self.$el.find(".part").get(section)).show();
                hull.restore();
            })
        },
        enabledDevices: function()
        {
            var number = 0;

            _.each(this.model.devices, function(device, key)
            {
                if(device.enabled)
                {
                    number++;
                }
            });

            return number;
        },
        toggleIoDevice: function(e)
        {
            var element = $(e.currentTarget);
            var name = element.attr('id').toLowerCase();

            if(element.prop('checked'))
            {
                element.parent().parent().find('.content').slideDown();
                this.model.devices[name].enabled = true;
            }
            else
            {
                if(this.enabledDevices() > 1)
                {
                    element.parent().parent().find('.content').slideUp();
                    this.model.devices[name].enabled = false;
                }
                else
                {
                    // Revert toggle..
                    element.prop('checked', !element.prop('checked'))
                }
            }
        },
        update: function()
        {            this.model.changeIoDevices({
                disk: {
                    enabled: this.model.devices.disk.enabled, // overkill
                    colorTimestamp: this.$el.find("#timestamp-color").val(),
                    markWithTimestamp: (this.$el.find("#timestamp-color").val() != "none") ? "true" : "false"
                },
                video: {
                    enabled: this.model.devices.video.enabled, // overkill
                    recordAfter:  this.$el.find("#recordAfter").val(),
                    fps:  this.$el.find("#fps").val()
                },
                webhook: {
                    enabled: this.model.devices.webhook.enabled, // overkill
                    url:  this.$el.find("#url").val()
                }
            });

            this.model.changeMotion({
                sensitivity: $("input#sensitivity").val(),
                detections: $("input#detections").val()
            });

            $("input[name='expositor__Hull__region']").val($("input[name='motion-hullselection']").val());
        },
        render: function()
        {
            this.$el.html(this.template(this.model));
            this.createSlider();
            this.createCarousel();
            this.setDevices();
            this.setColor();
            this.setRegionSelector();
            return this;
        }
    });

    return SettingsBasicMotionView;
});