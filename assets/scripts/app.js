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

            $.ajaxSetup({
                dataType: 'json'
            }, true);
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
        }
    };
    return _.extend(app, Backbone.Events);
});
