define([
    'jquery',
    'bootstrap',
    'underscore',
    'backbone',
    'router'
], function($, Bootstrap, _, Backbone, Router){
    var app = {
        run: function(){
            this.initialize();
            Router.start();
        },
        initialize: function(){
            this.initUser();
            this.initEvents();
            this.initComponents();

        },
        initUser: function(){
            var self = this;
            require([
                'models/user',
                'views/site/topPanel'
            ], function(User, View){
                self.user = new User();
                var view = new View({model: self.user});
                self.user.authenticate();
                view.render();
            });
        },
        initEvents: function(){
        },
        initComponents: function(){
            var self = this;
            $.ajaxSetup({
                global: true,
                dataType: 'json',
                statusCode: {
                    404: function(xhr){
                        //self.triggerError(404, xhr);
                    }
                }
            });

            // register handlebars helpers
            require([
                'handlebars',
                'libs/timeago/timeago',
                'libs/markdown-js/markdown',
            ], function(Handlebars, timeago){
                Handlebars.registerHelper('loginRequire', function(route){
                    if(!App.user.get('isGuest'))
                        return route;
                    return '/login';
                });

                Handlebars.registerHelper('markdown', function(content){
                    return new Handlebars.SafeString(markdown.toHTML(content));
                });

                Handlebars.registerHelper('timeago', timeago);
            });
        },
        redirect: function(route){
            Backbone.history.navigate(route, true);
        },
        setTitle: function(title){
            console.log('Set title: ', title);
        }
    };
    return _.extend(app, Backbone.Events);
});
