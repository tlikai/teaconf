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
            $(document.body).on('click', '*[modal]', function(e){
                var target = $(e.currentTarget);
                var view = target.attr('modal');
                require([
                    'views/' + view
                ], function(View){
                    var view = new View();
                    view.render();
                });
            });
        },
        initComponents: function(){
            $.ajaxSetup({
                dataType: 'json'
            }, true);

            // register handlebars helpers
            require([
                'handlebars',
            ], function(Handlebars){
                Handlebars.registerHelper('loginRequire', function(route){
                    if(!App.user.get('isGuest'))
                        return route;
                    return 'site/login';
                });
            });
        }
    };
    return _.extend(app, Backbone.Events);
});
