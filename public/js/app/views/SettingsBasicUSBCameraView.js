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

        initialize: function(model)
        {
            this.model = model;
        },
        update: function()
        {

        },
        render: function()
        {
            this.$el.html(this.template(this.model));
            return this;
        }
    });

    return SettingsBasicUSBCameraView;
});