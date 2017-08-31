/**
* Images Model
**/
define(["underscore", "backbone"], function (_, Backbone)
{ 
    var Images = Backbone.Model.extend({
        defaults: {
            // will need to include a tie breaker attribute in both models
            type: 'image'
        }
    }),
    Videos = Backbone.Model.extend({
        defaults: {
            // tie breaker
            type: 'video'
        }
    });

    var ImagesCollection = Backbone.Collection.extend({
        page: 1,
        lastTime: undefined,
        take: 12,
        model: function(model, options)
        {
            switch(model.type) {
                case 'image':
                    return new Images(model, options);
                    break;
                case 'video':
                    return new Videos(model, options);
                    break;
            }
        },
        setPage: function(page)
        {
            this.page = page;
        },
        setLastTime: function(time)
        {
            this.lastTime = time
        },
        setDay: function(day)
        {
            this.day = day;
        },
        setStartTime: function(time)
        {
            this.time = time;
        },
        fetch: function(options)
        {
            typeof(options) != 'undefined' || (options = {});
            
            this.url = _baseUrl + '/api/v1/images/' + this.day + '/' + this.take + '/' + this.page;
            
            // if a start time is selected
            if(this.time >= 0 && this.time <= 24)
            {
                this.url += '/' + this.time;
            }
            else if(this.time == null)
            {
                this.url += '/0';
            }
            
            var self = this;
            var success = options.success;
            options.success = function(resp)
            {
                if(success) success(self, resp);
            };
            return Backbone.Collection.prototype.fetch.call(this, options);
        },
    });
    return ImagesCollection;
});