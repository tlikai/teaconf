define([
    'jquery',
    'underscore',
    'backbone',
], function($, _, Backbone){
    return Backbone.Router.extend({
        initialize: function(){
            this.route(/(popular|recent|watch|suggest)\/*(\d+)*/, 'index');
            this.route(/node\/(\w+)\/*(popular|recent|watch|suggest)*\/*(\d+)*/, 'node');
        },
        routes: {
            '': 'index',
            'topic/create': 'create',
            'topic/:id': 'view'
        },
        index: function(filter, page){
            this.list(null, filter, page);
        },
        node: function(node, filter, page){
            this.list(node, filter, page);
        },
        list: function(node, filter, page){
            console.log('node:', node);
            console.log('filter:', filter);
            console.log('page:', page);
            require([
                'collections/topics',
                'views/topic/list'
            ], function(Topics, View){
                var topics = new Topics();
                topics.page = page || 0;
                topics.node = node || null;
                filter && (topics.filter = filter);
                var view = new View({collection: topics});
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
