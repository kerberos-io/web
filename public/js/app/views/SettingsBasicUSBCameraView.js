/**********************
*  USB Camera View
****/

define(["underscore", "backbone", "app/views/BaseView"], function (_, Backbone, BaseView)
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
            $(".rotate .image").css({'transform':'rotate('+this.model.usbcamera.angle+'deg)'})
        },
        update: function()
        {
            this.model.changeUSBCamera({
                width: $("#usbcamera-view .width").val(),
                height: $("#usbcamera-view .height").val(),
                angle: this.model.usbcamera.angle // overkill
            });
        },
        render: function()
        {
            this.$el.html(this.template(this.model));
            console.log(this.model);
            this.rotate();
            return this;
        }
    });

    return SettingsBasicUSBCameraView;
});