define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/user/settings.html',
    'libs/jquery-html5-upload/jquery.html5_upload'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        el: $('#container'),
        render: function(){
            console.log('render: user/settings');
            var self = this;
            var ctemplate = Handlebars.compile(template);
            var data = {
                user: this.model.toJSON(),
            };
            this.$el.html(ctemplate(data));
            this.setActive(this.page);

            require([
                'views/user/settings/' + this.page
            ], function(View){
                var view = new View({
                    el: self.$('.span10 .box'),
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
