/*******************
*  SystemKerberosView
****/

define(["underscore", "backbone", "app/views/BaseView", "remodal"], 
    function (_, Backbone, BaseView, remodal)
{ 
    var SystemKerberosView = BaseView.extend(
    {
        el : '#kerberos .view',
        view : 'system-kerberos',

        initialize: function(translation, system)
        {
            this.model = {};
            this.model.translation = translation;
            this.system = system;
        },
        fetchData: function(callback)
        {
            $.get( _baseUrl + "/api/v1/system/kerberos", function(data)
            {
                callback(data);
            });
        },
        render: function(data)
        {
            this.model.kerberos = data;
            this.$el.html(this.template(this.model));

            var self = this;
            this.$el.find("#clean").click(function()
            {
                self.system.clean();
            });

            var modal = this.$el.find('[data-remodal-id=logging]').remodal({});

            this.$el.find("pre.zoom").click(function()
            {
                modal.open();
            });

            return this;
        }
    });

    return SystemKerberosView;
});