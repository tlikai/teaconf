define([
    'jquery',
    'bootstrap',
    'underscore',
    'backbone',
    'router'
], function($, Bootstrap, _, Backbone, Router){
    return {
        run: function(){
            this.initUser();
            this.initEvents();
            Router.initialize();
        },
        initUser: function(){
            require([
                'views/site/topPanel'
            ], function(View){
                var view = new View();
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
});
