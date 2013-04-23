define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'models/node',
    'text!templates/topic/list.html'
], function($, _, Backbone, Handlebars, Node, template){
    return Backbone.View.extend({
        el: $('#container'),
        initialize: function(){
            this.listenTo(this.collection, 'change', this.renderTopics);
        },
        render: function(){
            var ctemplate = Handlebars.compile(template);
            var data = {
                node: this.collection.node,
                user: App.user.toJSON()
            };

            Handlebars.registerHelper('nodePath', function(node) {
                if(node)
                    return '/node/' + node;
                return '';
            });

            this.$el.html(ctemplate(data));
            this.setActive(this.collection.tab);
            this.renderTopics();
            return this;
        },
        setActive: function(tab){
            this.$('.' + tab).addClass('active');
        },
        renderTopics: function(){
            var self = this;
            require([
                'views/topic/item'
            ], function(View){
                self.collection.fetch({
                    success: function(topics){
                        topics.each(function(topic){
                            var view = new View({
                                el: self.$('.main .topics'),
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
