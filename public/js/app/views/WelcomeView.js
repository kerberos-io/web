/*****************
*  Welcome view
****/

define(["jquery", "underscore", "backbone", "app/views/BaseView"], function ($, _, Backbone, BaseView)
{
    var WelcomeView = BaseView.extend(
    {
        el : '#introduction',
        view : 'welcome',

        events:
        {
            "keyup #password-1": "changePassword",
            "keyup #password-2": "changePassword",
            "click #finish": "finish",
        },
        initialize: function(translations)
        {
            this.model = {};
            this.model.translation = translations;
        },
        changePassword: function()
        {
            var password1 = this.$el.find("#password-1");
            var password2 = this.$el.find("#password-2");

            if(password1.val() != password2.val())
            {
                password2.css({'border-bottom': '1px solid #943633'});
            }
            else
            {
                password2.css({'border-bottom': '1px solid #ccc'});
            }
        },
        finish: function(event)
        {
            $(this.el).off('click', '#finish');
            $("#cloud, #finish").fadeOut();
            $(".load5").show();

            var element = $(event.currentTarget);
            var username = this.$el.find("#username");
            var password1 = this.$el.find("#password-1");
            var password2 = this.$el.find("#password-2");

            var data = {
                'username': username.val(),
                'password1': password1.val(),
                'password2': password2.val()
            };

            $.post(_baseUrl + "/api/v1/user/install", data, function(data)
            {
                var refreshIntervalId = setInterval(function() {
                  $.get(_baseUrl + "/api/v1/user/installation", function(result){
                      if(result && result.completed) {
                        clearInterval(refreshIntervalId);
                        $(".welcome").fadeOut(500, function(){
                          window.location.href = '/login';
                        });
                      }
                  });
                }, 500);
            });

            return false;
        },
        render: function(callback)
        {
            this.$el.html(this.template(this.model));

            var carousel = this.carousel = this.$el.find('.owl-carousel');
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
                self.$el.find("h2.step span.text").html($(self.$el.find(".part").get(section)).attr('info'));
                self.$el.find("h2.step i").removeClass().addClass("fa").addClass($(self.$el.find(".part").get(section)).attr('icon'));
                $(self.$el.find(".part").get(section)).show();
                window.scrollTo(0,0);
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
