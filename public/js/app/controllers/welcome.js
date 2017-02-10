/*************************
*   Welcome
**/

define(["jquery", "underscore", "backbone", "remodal", "carousel", "app/views/WelcomeView"], 
	function ($, _, Backbone, remodal, carousel, WelcomeView)
{ 
    return {
        initialize: function()
        {
            var self = this;
            
            //self.openIntroduction();

            $(document).ready(function()
            {
                $(".center").fadeIn(2000);
                $(".next").click(function()
                {
                    var data = {
                        language: $("#language").val()
                    };

                    $.post(_baseUrl + "/api/v1/user/language", data, function(data)
                    {
                        $(".circle").css({'background-image': 'none'});
                        $(".circle").addClass('scale');
                        $("form#welcome").remove();
                        setTimeout(function()
                        {
                            self.openIntroduction();
                        },500);
                    });
                })
            });
        },
        openIntroduction: function()
        {
            var welcomeView = new WelcomeView();

            $.get(_baseUrl + "/api/v1/translate/welcome", function(translation)
            {
                welcomeView.initialize(translation);
                welcomeView.render(function()
                {
                    $("body").css({'background': 'white'});
                    $(".content").remove();
                    $("footer").addClass("black");
                    $(".logo_verstraetenio").css({'background': 'url(/images/logo_verstraetenio_black.png)'});
                    $("div.center").css({'top': 0});
                    $("#introduction").fadeIn(1200);
                    $("body").append($('<div class="logo"></div>').fadeIn(1200));
                });
            });
        }
    };
});