define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/topic/item.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        initialize: function(){
            this.model.bind('change', this.render);
        },
        render: function(){
            console.log('render: topic/item');
            var ctemplate = Handlebars.compile(template);
            var data = {
                topic: this.model.toJSON()
            };
            this.$el.append(ctemplate(data));
        }
    });
});
