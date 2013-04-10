define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/topic/index.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        el: $('#container'),
        node: null,
        page: null,
        filter: null,
        render: function(){
            var ctemplate = Handlebars.compile(template);
            this.$el.html(ctemplate());
            this.$('.' + this.filter).addClass('active');
            this.renderTopics();
            return this;
        },
        renderTopics: function(){
            var node = this.node;
            var page = this.page;
            var filter = this.filter;
            require([
                'collections/topics',
                'views/topic/item'
            ], function(Topics, Item){
                var topics = new Topics();
                topics.fetch({
                    data: {
                        node: node,
                        page: page,
                        filter: filter
                    },
                    success: function(){
                        topics.each(function(topic){
                            var view = new Item({
                                el: this.$('.main .topics'),
                                model: topic 
                            });
                            view.render();
                        });
                    }
                });
            });
        }
    });
});
