define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'models/notification',
    'text!templates/user/notifications/unread.html'
], function($, _, Backbone, Handlebars, Notification, template){
    return Backbone.View.extend({
        events: {
            'click .notifications .item': 'readOne',
            'click .readall': 'readAll'
        },
        render: function(){
            console.log('render: user/notifications/unread');
            var self = this;
            var ctemplate = Handlebars.compile(template);
            this.$el.html(ctemplate());

            require([
                'views/user/notifications/item'
            ], function(View){
                self.collection.fetch({
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
        },
        readOne: function(e){
            e.preventDefault();
            var $item = $(e.currentTarget);
            var id = $item.attr('data-id');
            this.markRead(id);
        },
        readAll: function(e){
            e.preventDefault();
            var self = this;

            this.$('[data-id]').each(function(i, o){
                var id = $(o).attr('data-id');
                self.markRead(id);
            });
        },
        markRead: function(id){
            Notification.readOne(id, {
                success: function(data){
                    self.$('[data-id='+id+']').fadeOut(100, function(){
                        this.remove();
                    });
                }
            });
        }
    });
});
