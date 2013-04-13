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
        index: function(tab, page){
            this.list(null, tab, page);
        },
        node: function(node, tab, page){
            this.list(node, tab, page);
        },
        list: function(node, tab, page){
            console.log('node:', node);
            console.log('tab:', tab);
            console.log('page:', page);
            require([
                'collections/topics',
                'views/topic/list'
            ], function(Topics, View){
                var topics = new Topics();
                topics.page = page || 0;
                topics.node = node || null;
                tab && (topics.tab = tab);
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
