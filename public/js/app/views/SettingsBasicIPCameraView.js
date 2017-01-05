/**********************
*  IP Camera View
****/

define(["underscore", "backbone", "app/views/BaseView"], function (_, Backbone, BaseView)
{ 
    var SettingsBasicIPCameraView = BaseView.extend(
    {
        el : '<div>',
        view : 'settings/settings-basic-ipcamera',
        model: undefined,

        initialize: function(model)
        {
            this.model = model;
        },
        update: function()
        {
            this.model.changeIPCamera({
                width: $("#ipcamera-view .width").val(),
                height: $("#ipcamera-view .height").val()
            });
        },
        render: function()
        {
            this.$el.html(this.template(this.model));
            return this;
        }
    });

    return SettingsBasicIPCameraView;
});