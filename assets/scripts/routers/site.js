define([
    'jquery',
    'underscore',
    'backbone',
], function($, _, Backbone){
    return Backbone.Router.extend({
        routes: {
            'logout': 'logout',
            '*action': 'default'
        },
        logout: function(){
            App.user.logout();
        },
        default: function(action) {
            console.log('route: Unknow', action);
        }
    });
});
