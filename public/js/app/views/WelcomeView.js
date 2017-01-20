/*****************
*  Welcome view
****/

define(["underscore", "backbone", "app/views/BaseView"], function (_, Backbone, BaseView)
{ 
    var WelcomeView = BaseView.extend(
    {
        el : '#introduction',
        view : 'welcome',

        events:
        {

        },
        initialize: function(model, translations)
        {
            this.model = model;
            //this.model.translation = translations;
        },
        render: function(callback)
        {
            this.$el.html(this.template(this.model));

            var carousel = this.$el.find('.owl-carousel');
            carousel.owlCarousel({
                items: 1,
                touchDrag: false,
                mouseDrag: false,
                nav: false
            });

            var self = this;
            carousel.on('changed.owl.carousel', function(event)
            {
                var section = event.item.index;
                self.$el.find("h2.step").html($(self.$el.find(".part").get(section)).attr('info'));
                $(self.$el.find(".part").get(section)).show();
            });

            this.$el.find('.nextStep').click(function() {
                carousel.trigger('next.owl.carousel');
            });

            callback();

            return this;
        }
    });

    return WelcomeView;
});