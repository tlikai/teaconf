define([
    'jquery',
    'underscore',
    'backbone',
], function($, _, Backbone){
    return Backbone.Router.extend({
        routes: {
            'settings': 'settings',
            'messages': 'messages'
        },
        settings: function(){
            require([
                'views/user/settings'
            ], function(View){
                var view = new View({model: App.user});
                view.render();
            });
        }
    });
});
