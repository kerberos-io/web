/**********************
*  Cloud View
****/

define(["underscore", "backbone", "app/views/BaseView"], function (_, Backbone, BaseView)
{
    var SettingsBasicCloudCameraView = BaseView.extend(
    {
        el : '<div>',
        view : 'settings/settings-basic-cloud',
        model: undefined,
        events: {
            'keyup #bucket': 'checkVerify',
            'keyup #folder': 'checkVerify',
            'keyup #public': 'checkVerify',
            'keyup #secret': 'checkVerify',
            'click #check-connectivity': 'checkConnectivity',
        },

        initialize: function(model)
        {
            this.model = model;
        },
        checkConnectivity: function()
        {
            this.$el.find("#loading-connectivity").show();
            this.$el.find(".ok").hide();
            this.$el.find(".not-ok").hide();


            var bucket = this.$el.find("#bucket input").val();
            var folder = this.$el.find("#folder input").val();
            var public = this.$el.find("#public input").val();
            var secret = this.$el.find("#secret input").val();

            var self = this;
            $.ajax({
                url: _baseUrl + "/api/v1/cloud/check",
                type: 'POST',
                data: {
                  bucket: bucket,
                  folder: folder,
                  public: public,
                  secret: secret
                },
                success: function(data)
                {
                    if(data && data['status'] == 200)
                    {
                        self.$el.find("#loading-connectivity").hide();
                        self.$el.find(".ok").show();
                    }
                    else
                    {
                        self.$el.find("#loading-connectivity").hide();
                        self.$el.find(".not-ok").show();
                    }
                },
                error: function(request, status, error)
                {
                    self.$el.find("#loading-connectivity").hide();
                    self.$el.find(".not-ok").show();
                }
            });
        },
        update: function()
        {
            this.model.changeKerberosCloud({
                bucket: this.$el.find("#bucket input").val(),
                folder: this.$el.find("#folder input").val(),
                public: this.$el.find("#public input").val(),
                secret: this.$el.find("#secret input").val(),
            });
        },
        checkVerify: function()
        {
          var bucket = this.$el.find("#bucket input").val();
          var folder = this.$el.find("#folder input").val();
          var public = this.$el.find("#public input").val();
          var secret = this.$el.find("#secret input").val();
          if(bucket != "" && folder != "" && public != "" && secret != "")
          {
              this.$el.find(".check-connectivity").css({'display': 'table'});
          }
          else
          {
              this.$el.find(".check-connectivity").css({'display': 'none'});
          }
        },
        render: function()
        {
            this.$el.html(this.template(this.model));
            this.checkVerify();
            return this;
        }
    });

    return SettingsBasicCloudCameraView;
});
