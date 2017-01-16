/**
* Users Model
**/
define(["underscore", "backbone"], function (_, Backbone)
{ 
    var Users = Backbone.Model.extend({});

    var UserCollection = Backbone.Collection.extend(
    {
    	model: Users,
        url: '/api/v1/users/current'
    });

    return UserCollection;
});