define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/topic/create.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        id: '#createTopicModal',
        render: function(){
            console.log('render: topic/create');
            var ctemplate = Handlebars.compile(template);
            var data = {};
            this.$el.html(ctemplate(data));
            $(document.body).append(this.$el);
            this.$el.find('.modal').modal();
            return this;
        }
    });
});
