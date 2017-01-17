/**********************
*  IP Camera View
****/

define(["underscore", "backbone", "app/views/BaseView", "seiyria-bootstrap-slider"], function (_, Backbone, BaseView, Slider)
{ 
    var SettingsBasicIPCameraView = BaseView.extend(
    {
        el : '<div>',
        view : 'settings/settings-basic-ipcamera',
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
            this.model.ipcamera.angle = (this.model.ipcamera.angle + 90) % 360; 
            this.rotate();
        },
        rotate: function()
        {
            this.$el.find(".rotate .image").css({'transform':'rotate('+this.model.ipcamera.angle+'deg)'})
        },
        createSlider: function()
        {
            var self = this;
            self.$el.find('.slider-delay, .slider-fps').slider({});
        },
        update: function()
        {
            this.model.changeIPCamera({
                width: this.$el.find("#ipcamera-view .width").val(),
                height: this.$el.find("#ipcamera-view .height").val(),
                angle: this.model.ipcamera.angle, // overkill
                delay: parseFloat(this.$el.find("#ipcamera-view .slider-delay").val()) * 1000,
                fps: parseInt(this.$el.find("#ipcamera-view .slider-fps").val()),
                url: this.$el.find("#ipcamera-view .url").val()
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

    return SettingsBasicIPCameraView;
});