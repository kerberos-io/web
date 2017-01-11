/**********************
*  USB Camera View
****/

define(["underscore", "backbone", "app/views/BaseView", "seiyria-bootstrap-slider", "app/controllers/hullselection"],
    function (_, Backbone, BaseView, Slider, hull)
{ 
    var SettingsBasicMotionView = BaseView.extend(
    {
        el : '<div>',
        view : 'settings/settings-basic-motion',
        model: undefined,
        events: {
            'click .rotate .image':'changeRotation'
        },

        initialize: function(model)
        {
            this.model = model;
        },
        createSlider: function()
        {
            var self = this;
            self.$el.find('.slider-delay, .slider-fps').slider({});
        },
        createCarousel: function()
        {
            var self = this;
            this.carousel = self.$el.find('.owl-carousel');
            this.carousel.owlCarousel({
                items: 1,
                touchDrag: false,
                mouseDrag: false,
                callbacks: true,
                nav: true,
                navText: [
                    "<i class='fa fa-arrow-left' aria-hidden='true'></i>",
                    "<i class='fa fa-arrow-right' aria-hidden='true'></i>"
                ],
            });
        },
        update: function()
        {
            $("input[name='expositor__Hull__region']").val($("input[name='motion-hullselection']").val());
        },
        render: function()
        {
            this.$el.html(this.template(this.model));
            this.createSlider();
            this.createCarousel();

            hull.setElement(this.$el.find("#region-selector"));
            hull.setImage("http://kerberos.web//capture//1484052174_6-823046_Frontdoorrr_regionCoordinates_numberOfChanges_160.jpg");
            hull.setImageSize(1280, 960);
            hull.setCoordinates($("input[name='expositor__Hull__region']").val());
            hull.setName("motion-hullselection");
            hull.initialize();

            var self = this;

            this.carousel.on('changed.owl.carousel', function(event)
            {
                var section = event.item.index;
                self.$el.find("#step").html($(self.$el.find(".part").get(section)).attr('description'))
                hull.restore();
            })

            return this;
        }
    });

    return SettingsBasicMotionView;
});