/*********************
*  Web settings view.
****/

define(["underscore", "backbone", "app/views/BaseView", "seiyria-bootstrap-slider", "app/controllers/dashboard_heatmap"],
    function (_, Backbone, BaseView, Slider, Heatmap)
{
    var SettingsWebView = BaseView.extend(
    {
        el : '#web-settings .web-content',
        view : 'settings-web',

        events:
        {
            "change .slider-radius": "changeRadius",
            "click #update-heatmap": "update"
        },
        initialize: function(translations)
        {
            this.model = {};
            this.model.translation = translations;
        },
        setRadius: function(radius)
        {
            this.model.radius = radius;
        },
        changeRadius: function(event)
        {
            var element = $(event.currentTarget);
            this.model.radius = element.val();

            Heatmap.changeRadius(this.model.radius);
        },
        createSlider: function()
        {
            var self = this;
            self.$el.find('.slider-radius').slider({});
        },
        render: function(model)
        {
            this.$el.html(this.template(this.model));

            Heatmap.initialize(
            {
                element: "heatmap",
                url: _baseUrl + "/api/v1/images/regions",
                urlSequence: _baseUrl + "/api/v1/images/latest_sequence",
                fps: "1",
                radius: this.model.radius,
                callback: function(){}
            });

            Heatmap.redraw();

            this.createSlider();

            return this;
        }
    });

    return SettingsWebView;
});
