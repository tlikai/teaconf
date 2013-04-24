define([
    'jquery',
    'underscore',
    'backbone',
], function($, _, Backbone){
    return Backbone.Router.extend({
        initialize: function(){
            this.route(/user\/*(\w+)*\/*(index|topics|likes|watch)*/, 'home');
            this.route(/settings\/*(profile|avatar|password)*/, 'settings');
            this.route(/notifications\/*(all)*/, 'notifications');
        },
        routes: {
            'notifications': 'notifications'
        },
        home: function(id, page){
            id = id || App.user.get('id');
            page = page || 'index';
            require([
                'models/user',
                'views/user/home'
            ], function(User, View){
                var user = new User({id: id});
                user.fetch({
                    success: function(model){
                        var view = new View({
                            model: model
                        });
                        view.page = page;
                        view.render();
                    }
                });
            });
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
