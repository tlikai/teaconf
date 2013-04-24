define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/user/home.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        el: $('#container'),
        render: function(){
            console.log('render: user/home');
            var self = this;
            var ctemplate = Handlebars.compile(template);
            var data = {
                user: this.model.toJSON(),
            };
            this.$el.html(ctemplate(data));
            this.setActive(this.page);

            require([
                'views/user/home/' + this.page
            ], function(View){
                var view = new View({
                    el: self.$('.span10'),
                    model: self.model
                });
                view.render();
            });
        },
        setActive: function(page) {
            this.$('.page-' + this.page).addClass('active');
        }
    });
});
