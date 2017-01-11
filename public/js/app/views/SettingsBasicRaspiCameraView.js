/**********************
*  RPI Camera View
****/

define(["underscore", "backbone", "app/views/BaseView", "seiyria-bootstrap-slider"], function (_, Backbone, BaseView, Slider)
{ 
    var SettingsBasicRPICameraView = BaseView.extend(
    {
        el : '<div>',
        view : 'settings/settings-basic-rpicamera',
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
            this.model.rpicamera.angle = (this.model.rpicamera.angle + 90) % 360; 
            this.rotate();
        },
        rotate: function()
        {
            this.$el.find(".rotate .image").css({'transform':'rotate('+this.model.rpicamera.angle+'deg)'})
        },
        createSlider: function()
        {
            var self = this;
            self.$el.find('.slider-delay, .slider-fps').slider({});
        },
        update: function()
        {
            this.model.changeIPCamera({
                width: $("#ipcamera-view .width").val(),
                height: $("#ipcamera-view .height").val()
            });
        },
        update: function()
        {
            this.model.changeRPICamera({
                width: this.$el.find("#rpicamera-view .width").val(),
                height: this.$el.find("#rpicamera-view .height").val(),
                angle: this.model.rpicamera.angle, // overkill
                delay: parseFloat(this.$el.find("#rpicamera-view .slider-delay").val()) * 1000,
                fps: parseInt(this.$el.find("#rpicamera-view .slider-fps").val())
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

    return SettingsBasicRPICameraView;
});