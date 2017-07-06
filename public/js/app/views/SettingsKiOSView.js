/*********************
*  KiOS settings view.
****/

define(["underscore", "backbone", "app/views/BaseView"],
    function (_, Backbone, BaseView)
{
    var SettingsKiOSView = BaseView.extend(
    {
        el : '#web-settings .kios-content',
        view : 'settings-kios',

        events:
        {
            "change #force-network": "updateToggle",
            "change #auto-removal": "updateToggle",
        },
        initialize: function(autoremoval, forcenetwork, translations)
        {
            this.model = {};
            this.model.autoremoval = autoremoval;
            this.model.forcenetwork = forcenetwork;
            this.model.translation = translations;
        },
        updateToggle: function(e)
        {
            var input = $(e.target);
            var isChecked = input.is(':checked');

            // We call the correct method in function
            // of the id attribute of the toggle.
            $.ajax({
                url: _baseUrl + "/api/v1/" + input.attr('id'),
                type: 'PUT',
                data: {'active': isChecked},
                success: function(data)
                {
                    console.log(data);
                }
            });
        },
        render: function(model)
        {
            this.$el.html(this.template(this.model));
            return this;
        }
    });

    return SettingsKiOSView;
});
