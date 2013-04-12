define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/topic/create.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        id: '#createTopic',
        events: {
            'click .submit': function(e){
                var self = this;
                var $submit = $(e.currentTarget);
                var $alert = this.$('.alert');
                var $modal = this.$('.modal');
                var attrs = {
                    node: this.$('select[name=node]').val(),
                    title: this.$('input[name=title]').val(),
                    content: this.$('textarea[name=content]').val()
                };
                console.log(attrs);
                $alert.fadeOut('fast');
                $submit.attr('disabled', true);

                require([
                        'models/topic'
                ], function(Topic){
                    var topic = new Topic();
                    topic.save(attrs, {
                        success: function(topic){
                            $alert.hide();
                            $modal.modal('hide');
                            Backbone.history.navigate('topic/' + topic.id, true);
                        },
                        error: function(model, xhr){
                            $alert.html(xhr.responseText).addClass('error').fadeIn('fast');
                            $submit.removeAttr('disabled');
                        }
                    });
                });
            }
        },
        render: function(){
            console.log('render: topic/create');
            var ctemplate = Handlebars.compile(template);
            var data = {};
            this.$el.append(ctemplate(data));
            $(document.body).append(this.$el);
            var self = this;
            this.$el.find('.modal').modal({keyboard: false, backdrop: 'static'}).on('hidden', function(){
                self.$el.remove();
            });

            require([
                'views/node/selector',
            ], function(View){
                var view = new View({
                    el: self.$('#nodeSelector')
                });
                view.render();
            });
            return this;
        }
    });
});
