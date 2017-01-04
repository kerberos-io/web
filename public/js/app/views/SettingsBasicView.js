/********************************************************************
*  Basic settings view: this is an easier view of the advanced view.
****/

define(["underscore", "backbone", "app/views/BaseView", "remodal", "app/views/SettingsBasicUSBCameraView"], 
    function (_, Backbone, BaseView, remoda, USBCameraView)
{ 
    var SettingsBasicView = BaseView.extend(
    {
        el : '#basic',
        view : 'settings-basic',
        options: undefined,

        model: undefined,

        modal: undefined,

        selected: undefined,
        object: undefined,
        subView: undefined,

        events:
        {
            "change #timezone-picker-basic" : "changeTimezone",
            "keyup div.name input": "changeName",
            "click .type": "changeType"
        },
        initialize: function(model)
        {
            this.model = model;
        },
        confirm: function()
        {
            this.modal.close();
            // if ok reselect device
            $("#camera .type").removeClass("active");
            element.addClass("active");
            alert("ok")
        },
        changeTimezone: function()
        {
            this.model.changeTimezone($("#timezone-picker-basic option:selected").val());
        },
        changeName: function()
        {
            this.model.changeName($("div.name input").val());
        },
        changeType: function(event)
        {
            this.object = $(event.currentTarget);
            this.selected = "#" + this.object.parent().attr('id');

            this.subView = eval("new " + this.object.attr('id') + 'View' + "()");

            if(this.subView)
            {
                this.subView.initialize(this.model);
                $("#settings-modal .modal-body > .view").html(this.subView.render().el)
                this.modal.open();
            }
        },
        render: function(model)
        {
            this.$el.html(this.template(this.model));
            
            // Set the time zone
            var timezone = this.model.getTimezone();
            this.model.setTimezone(timezone);

            this.modal = $('[data-remodal-id=settings]').remodal({});

            var self = this;
            $('[data-remodal-id=settings] .remodal-confirm').click(function()
            {
                self.subView.update();
                $(self.selected + " .type").removeClass("active");
                $(self.object).addClass("active");  
            })

            return this;
        }
    });

    return SettingsBasicView;
});