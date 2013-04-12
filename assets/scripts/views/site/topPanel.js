define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/site/topPanel.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        el: $('#topPanel'),
        initialize: function(){
            this.listenTo(App.user, 'change', this.render);
        },
        render: function(){
            console.log('render: site/topPanel');
            var ctemplate = Handlebars.compile(template);
            var data = {
                user: App.user.toJSON()
            };
            console.log('login:', data);
            this.$el.html(ctemplate(data));
            return this;
        }
    });
});
