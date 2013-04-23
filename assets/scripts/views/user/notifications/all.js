define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/user/notifications/all.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        render: function(){
            console.log('render: user/notifications/all');
            var self = this;
            var ctemplate = Handlebars.compile(template);
            this.$el.html(ctemplate());

            require([
                'views/user/notifications/item'
            ], function(View){
                self.collection.fetch({
                    data: {
                        unread: false
                    },
                    success: function(notifications){
                        notifications.each(function(notification){
                            var view = new View({
                                el: self.$('.notifications'),
                                model: notification
                            });
                            view.render();
                        });
                    }
                });
            });
        }
    });
});
