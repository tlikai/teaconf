define([
    'jquery',
    'underscore',
    'backbone',
], function($, _, Backbone){
    return Backbone.Router.extend({
        initialize: function(){
            this.route(/settings\/*(profile|avatar|password)*/, 'settings');
            this.route(/notifications\/*(all)*/, 'notifications');
        },
        routes: {
            'notifications': 'notifications'
        },
        settings: function(page){
            page = page || 'profile';
            require([
                'views/user/settings'
            ], function(View){
                var view = new View({
                    model: App.user
                });
                view.page = page;
                view.render();
            });
        },
        notifications: function(page){
            page = page || 'unread';
            require([
                'views/user/notifications',
                'collections/notifications'
            ], function(View, Notifications){
                var notifications = new Notifications();
                var view = new View({
                    collection: notifications
                });
                view.page = page;
                view.render();
            });
        }
    });
});
