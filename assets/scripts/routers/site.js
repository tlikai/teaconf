define([
    'jquery',
    'underscore',
    'backbone',
], function($, _, Backbone){
    return Backbone.Router.extend({
        initialize: function(){
            this.route(/(login|register|resetPassword|create|nodes)/, 'loadView');
        },
        routes: {
            'logout': 'logout',
            '*action': 'default'
        },
        logout: function(){
            App.user.logout();
        },
        loadView: function(view){
            view = view || 'login';
            require([
                'views/site/' + view,
            ], function(View){
                new View().render();
            });
        },
        default: function(action) {
            console.log('route: Unknow', action);
        }
    });
});
