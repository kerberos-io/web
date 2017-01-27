define(["underscore", "backbone"], function (_, Backbone)
{
    /***********************************************
    * Array Storage Driver (Save mustache templates)
    */
    var ArrayStorage = function()
    {
        this.storage = {};
    };
    ArrayStorage.prototype.get = function(key)
    {
        return this.storage[key];
    };
    ArrayStorage.prototype.set = function(key, val)
    {
        return this.storage[key] = val;
    };

    /****************************************
    * Base View
    */
    var BaseView = Backbone.View.extend(
    {
        templateDriver: new ArrayStorage,
        viewPath: _jsBase + 'mustache/',
        template: function()
        {
            var view, data, template, self;
            switch(arguments.length)
            {
                case 1:
                    view = this.view;
                    data = arguments[0];
                    break;
                case 2:
                    view = arguments[0];
                    data = arguments[1];
                    break;
            }

            compiledTemplateFunction = this.getTemplate(view, false);
            self = this;
            return compiledTemplateFunction(data);
        },
        assign: function (view, selector, data)
        {
            if(view)
            {
                view.assigned();
                view.setElement($(selector)).render(data);
            }
        },
        close: function()
        {
            if(this.views)
            {
                for(var view in this.views)
                {
                    this.views[view].close();
                }
            }
            this.$el.children().remove();
            
            if(this.collection)
            {
                this.collection.reset();
            }
            
            this.undelegateEvents();
        },
        getTemplate: function(view)
        {
            return /*this.templateDriver.get(view) || */this.fetch(view);
        },
        setTemplate: function(name, template)
        {
            return this.templateDriver.set(name, template);
        },
        fetch: function(view)
        {
            var markup = $.ajax({ async: false, url: this.viewPath + view.split('.').join('/') + '.mustache' }).responseText;
            return this.setTemplate(view, Mustache.compile(markup));
        },
        render: function(options)
        {
            this.preRender(options);
            this.postRender();
        },
    });

    return BaseView;    
});