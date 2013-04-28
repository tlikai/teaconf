define([
    'jquery',
    'underscore',
    'backbone',
], function($, _, Backbone){
    return Backbone.Router.extend({
        routes: {
            'logout': 'logout',
            'resetPassword': 'resetPassword',
            '*action': 'default'
        },
        logout: function(){
            App.user.logout();
        },
        resetPassword: function(){
            require([
                'views/site/resetPassword',
            ], function(View){
                var view = new View();
                view.render();
            });
        },
        default: function(action) {
            console.log('route: Unknow', action);
        }
    });
});
