/*******************
*  NewsView
****/

define(["underscore", "backbone", "app/views/BaseView", "remodal"],
    function (_, Backbone, BaseView, remodal)
{
    var NewsView = BaseView.extend(
    {
        el : '#news .view',
        view : 'news',

        initialize: function(translation)
        {
            this.model = {};
            this.model.translation = translation;
        },
        fetchData: function(callback)
        {
            var zendesk = "https://kerberosio.zendesk.com/api/v2/help_center/";

            $.get(zendesk + "en-us/sections.json", function(data)
            {
                if(data)
                {
                    var announcements = _.find(data.sections, function(section)
                    {
                        return section.name === "Announcements";
                    });

                    $.get(zendesk + "articles/search.json?query=&section=" + announcements.id, function(data)
                    {
                        var articles = [];

                        if(data)
                        {
                            articles = data.results;

                            var monthNames = [
                              "January", "February", "March",
                              "April", "May", "June", "July",
                              "August", "September", "October",
                              "November", "December"
                            ];

                            articles = articles.sort(function(a, b) {
                                a = new Date(a.created_at);
                                b = new Date(b.created_at);
                                return a>b ? -1 : a<b ? 1 : 0;
                            });

                            for(var i = 0; i < articles.length; i++)
                            {
                                var date = new Date(articles[i].created_at);

                                var day = date.getDate();
                                var monthIndex = date.getMonth();
                                var year = date.getFullYear();

                                articles[i].date = day + " " + monthNames[monthIndex] + " " + year;
                            }
                        }

                        callback(articles);
                    })
                    .fail(function() {
                      callback([]);
                    });
                }
            })
            .fail(function() {
              callback([]);
            });
        },
        render: function(data)
        {
            if(data && data.length)
            {
                this.$el.html(this.template({articles: data}));
            }
            else
            {
                this.$el.html("Couldn't retrieve any news, sorry.");
            }

            return this;
        }
    });

    return NewsView;
});
