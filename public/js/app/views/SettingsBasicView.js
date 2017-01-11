/********************************************************************
*  Basic settings view: this is an easier view of the advanced view.
****/

define(["underscore", "backbone", "app/views/BaseView", "remodal",
 "app/views/SettingsBasicUSBCameraView",
 "app/views/SettingsBasicIPCameraView",
 "app/views/SettingsBasicRaspiCameraView",
  "app/views/SettingsBasicMotionView"], 
    function (_, Backbone, BaseView, remodal,
        USBCameraView, IPCameraView, RaspiCameraView, MotionView)
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
        image: undefined,

        events:
        {
            "change #timezone-picker-basic" : "changeTimezone",
            "keyup div.name input": "changeName",
            "click .type": "changeType"
        },
        initialize: function(model, image)
        {
            this.model = model;
            this.image = image;
        },
        refresh: function()
        {
            this.model.refresh();
        },
        selectCapture: function()
        {
            var capture = this.model.getCapture();
            $("#"+capture).addClass("active");
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
            this.subView = eval("new " + this.object.attr('id') + 'View()');

            if(this.subView)
            {
                this.refresh();
                this.subView.initialize(this.model, this.image);
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

            // Select capture device
            this.selectCapture();

            var self = this;
            self.modal = $('[data-remodal-id=settings]').remodal({ hashTracking: false });

            $('[data-remodal-id=settings] .remodal-confirm').unbind('click').click(function()
            {
                self.subView.update();
                $(self.selected + " .type").removeClass("active");
                $(self.object).addClass("active");  
            });

            return this;
        }
    });

    return SettingsBasicView;
});