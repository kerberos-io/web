/**********************
*  RPI Camera View
****/

define(["underscore", "backbone", "app/views/BaseView"], function (_, Backbone, BaseView)
{ 
    var SettingsBasicRPICameraView = BaseView.extend(
    {
        el : '<div>',
        view : 'settings/settings-basic-rpicamera',
        model: undefined,

        initialize: function(model)
        {
            this.model = model;
        },
        update: function()
        {
            this.model.changeRPICamera({
                width: $("#rpicamera-view .width").val(),
                height: $("#rpicamera-view .height").val()
            });
        },
        render: function()
        {
            this.$el.html(this.template(this.model));
            return this;
        }
    });

    return SettingsBasicRPICameraView;
});