/*************************
*   Welcome
**/

define(["jquery", "underscore", "backbone", "remodal", "carousel", "app/views/WelcomeView"], 
	function ($, _, Backbone, remodal, carousel, WelcomeView)
{ 
    return {
        translation: {},

        initialize: function(translation)
        {
            var self = this;
            self.translation = translation;

            //self.openIntroduction();
            //$(".center").show();
            //$("form#welcome").remove();
            
            $(document).ready(function()
            {
                $(".center").fadeIn(2000);
                $(".next").click(function()
                {
                    $(".circle").css({'background-image': 'none'});
                    $(".circle").addClass('scale');
                    $("form#welcome").remove();
                    setTimeout(function()
                    {
                        self.openIntroduction();
                    },500);
                })
            });
        },
        openIntroduction: function()
        {
            var welcomeView = new WelcomeView();
            welcomeView.initialize();
            welcomeView.render(function()
            {
                $("body").css({'background': 'white'});
                $(".content").remove();
                $("footer").addClass("black");
                $(".logo_verstraetenio").css({'background': 'url(/images/logo_verstraetenio_black.png)'});
                $("div.center").css({'top': 0});
                $("#introduction").fadeIn(1200);
            });
        }
    };
});