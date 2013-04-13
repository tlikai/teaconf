define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/topic/view.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        el: $('#container'),
        initialize: function(){
            this.model.bind('change', this.render);
        },
        render: function(){
            var ctemplate = Handlebars.compile(template);
            var data = {
                topic: this.model.toJSON()
            };
            this.$el.html(ctemplate(data));
            this.renderPosts();
        },
        renderPosts: function(){
            var topic = this.model;
            require([
                'collections/posts',
                'views/post/item'
            ], function(Posts, PostView){
                var posts = new Posts();
                posts.fetch({
                    data: {
                        topic_id: topic.id,
                    },
                    success: function(){
                        posts.each(function(post){
                            var view = new PostView({
                                el: this.$('.posts'),
                                model: post
                            });
                            view.render();
                        });
                    }
                });
            });
        }
    });
});
