define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/site/topPanel.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        el: $('#topPanel'),
        render: function(){
            console.log('render: site/topPanel');
            var ctemplate = Handlebars.compile(template);
            var data = {};
            this.$el.html(ctemplate(data));
            return this;
        }
    });
});
