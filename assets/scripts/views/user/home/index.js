define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/user/home/index.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        render: function(){
            console.log('render: user/home/index');
            var self = this;
            var ctemplate = Handlebars.compile(template);
            this.$el.html(ctemplate());
        }
    });
});
