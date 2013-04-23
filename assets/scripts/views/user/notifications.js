define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/user/notifications.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        el: $('#container'),
        render: function(){
            console.log('render: user/notifications');
            var self = this;
            var ctemplate = Handlebars.compile(template);
            this.$el.html(ctemplate());
            this.setActive(this.page);

            require([
                'views/user/notifications/' + this.page
            ], function(View){
                var view = new View({
                    el: self.$('.span10 .box'),
                    collection: self.collection
                });
                view.render();
            });
        },
        setActive: function(page) {
            this.$('.page-' + this.page).addClass('active');
        }
    });
});
