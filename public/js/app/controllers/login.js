/****************************************
*
*   LoginController:  try to sign in a user.
*
**/

define(["jquery"], function($)
{
    return {
        form: undefined,
        username: undefined,
        password: undefined,
        messageBag: undefined,
        url: "/api/v1/login/login",
        setForm: function(form)
        {
            this.form = form;
        },
        setCredentials: function(username, password)
        {
            this.username = username;
            this.password = password;
        },
        setMessageBag: function(messageBag)
        {
            this.messageBag = messageBag;
            this.messageBag.hide();
        },
        initialize: function()
        {
            $(document).ready(function()
            {
                $(".center").fadeIn(2000);
            });

            if(this.form == undefined) return false;

            var messageBag = this.messageBag;
            var endpoint = _baseUrl + this.url;
            var username = this.username;
            var password = this.password;
            var form = this.form;

            this.form.submit(function()
            {
                var credentials = {
                    "username": username.val(),
                    "password": password.val()
                };

                $.post(endpoint, credentials)

                // Success
                .done(function(data)
                {
                    location.reload();
                    $(".login").fadeOut(1000, function(){
                        $(".login").html('<div class="load1"><div class="loader"></div></div>');
                        $(".login").show();
                    });
                })

                // Failed
                .fail(function(data)
                {   
                    // Do shake animation
                    form.addClass("shake shake-horizontal shake-constant");
                    setTimeout(function(){
                        form.removeClass("shake shake-horizontal shake-constant");
                    },400);

                    // Show error message
                    messageBag.html(data);
                    messageBag.show();
                });

                return false;
            });
        }
    };
});