define([
    'jquery',
    'underscore',
    'backbone',
], function($, _, Backbone){
    return Backbone.Router.extend({
        routes: {
            '': 'index',
            'topics/:filter': 'list',
            'topic/create': 'create',
            'topic/:id': 'view'
        },
        index: function(){
            console.log('route: topic/index');
            this.list('popular');
        },
        list: function(filter){
            console.log('route: topic/list');
            require([
                'views/topic/index'
            ], function(View){
                var view = new View();
                view.filter = filter;
                view.render();
            });
        },
        view: function(id) {
            console.log('route: topic/view');
            require([
                'models/topic',
                'views/topic/view'
            ], function(Topic, View){
                var topic = new Topic({id: id});
                topic.fetch({
                    success: function(){
                        var view = new View({model: topic});
                        view.render();
                    }
                });
            });
        }
    });
});
