define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/topic/index.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        el: $('#container'),
        render: function(){
            var ctemplate = Handlebars.compile(template);
            this.$el.html(ctemplate());
            this.$('.' + this.filter).addClass('active');
            this.renderTopics();
            return this;
        },
        renderTopics: function(){
            var filter = this.filter;
            require([
                'collections/topics',
                'views/topic/item'
            ], function(Topics, Item){
                var topics = new Topics();
                topics.fetch({
                    data: {
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
