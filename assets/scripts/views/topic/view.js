define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/topic/view.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        el: $('#container'),
        events: {
            'click .action-watch': 'watch',
            'click .action-like': 'like',
            'click .reply-form .submit': 'reply'
        },
        initialize: function(){
            this.listenTo(this.model, 'change', this.render);
        },
        render: function(){
            var ctemplate = Handlebars.compile(template);
            var data = {
                topic: this.model.toJSON(),
                haveReply: this.model.get('posts_count') != 0
            };
            this.$el.html(ctemplate(data));
            this.renderPosts();
        },
        renderPosts: function(){
            var self = this;
            var topic = this.model;
            require([
                'collections/posts',
                'views/post/item'
            ], function(Posts, PostView){
                self.posts = new Posts();
                self.posts.fetch({
                    data: {
                        topic_id: topic.id,
                    },
                    success: function(){
                        self.posts.each(function(post){
                            var view = new PostView({
                                el: this.$('.posts'),
                                model: post
                            });
                            view.render();
                        });
                    }
                });
            });
        },
        watch: function(e){
            e.preventDefault();
            var $target = $(e.currentTarget);
            var id = $target.attr('topic');
            $.ajax({
                url: API_URL + '/topic/watch/' + id,
                method: 'POST',
                success: function(data){
                    $target.html('已关注').addClass('watched');
                }
            });
        },
        like: function(){
        
        },
        reply: function(e){
            e.preventDefault();
            var self = this;
            var $alert = this.$('.reply-form .alert');
            var $submit = $(e.currentTarget);
            var attrs = {
                topic_id: this.model.get('id'),
                content: this.$('textarea[name=content]').val()
            };

            $alert.fadeOut('fast');
            $submit.attr('disabled', true);

            require([
                'models/post',
                'collections/posts'
            ], function(Post, Posts){
                var post = new Post();
                var posts = new Posts();
                post.save(attrs, {
                    success: function(post){
                        var posts_count = self.model.get('posts_count') + 1;
                        self.model.set('posts_count', posts_count);
                        this.$('textarea[name="content"]').val('');
                        $submit.removeAttr('disabled');
                    },
                    error: function(model, xhr){
                        $alert.html(xhr.responseText).addClass('error').fadeIn('fast');
                        $submit.removeAttr('disabled');
                    }
                });
            });
        }
    });
});
