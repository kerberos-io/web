/********************************************************************
*  Basic settings view: this is an easier view of the advanced view.
****/

define(["underscore", "backbone", "app/views/BaseView"], function (_, Backbone, BaseView)
{ 
    var SettingsBasicView = BaseView.extend(
    {
        el : '#basic',
        view : 'settings-basic',
        options: undefined,
        model: undefined,

        events:
        {
            "change #timezone-picker-basic" : "changeTimezone",
            "keyup div.name input": "changeName",
        },
        initialize: function(model)
        {
            this.model = model;
        },
        changeTimezone: function()
        {
            this.model.changeTimezone($("#timezone-picker-basic option:selected").val());
        },
        changeName: function()
        {
            this.model.changeName($("div.name input").val());
        },
        render: function(model)
        {
            this.$el.html(this.template(this.model));
            
            // Set the time zone
            var timezone = this.model.getTimezone();
            this.model.setTimezone(timezone);

            return this;
        }
    });

    return SettingsBasicView;
});