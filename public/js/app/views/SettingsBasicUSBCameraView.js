/**********************
*  USB Camera View
****/

define(["underscore", "backbone", "app/views/BaseView", "seiyria-bootstrap-slider", "carousel"],
    function (_, Backbone, BaseView, Slider, carousel)
{ 
    var SettingsBasicUSBCameraView = BaseView.extend(
    {
        el : '<div>',
        view : 'settings/settings-basic-usbcamera',
        model: undefined,
        events: {
            'click .rotate .image':'changeRotation'
        },

        initialize: function(model)
        {
            this.model = model;
        },
        changeRotation: function()
        {
            this.model.usbcamera.angle = (this.model.usbcamera.angle + 90) % 360; 
            this.rotate();
        },
        rotate: function()
        {
            this.$el.find(".rotate .image").css({'transform':'rotate('+this.model.usbcamera.angle+'deg)'})
        },
        createSlider: function()
        {
            var self = this;
            self.$el.find('.slider-delay, .slider-fps').slider({});
        },
        update: function()
        {
            this.model.changeUSBCamera({
                width: this.$el.find("#usbcamera-view .width").val(),
                height: this.$el.find("#usbcamera-view .height").val(),
                angle: this.model.usbcamera.angle, // overkill
                delay: parseFloat(this.$el.find("#usbcamera-view .slider-delay").val()) * 1000,
                fps: parseInt(this.$el.find("#usbcamera-view .slider-fps").val())
            });
        },
        render: function()
        {
            this.$el.html(this.template(this.model));
            this.rotate();
            this.createSlider();
            return this;
        }
    });

    return SettingsBasicUSBCameraView;
});