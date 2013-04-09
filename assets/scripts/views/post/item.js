define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/post/item.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        initialize: function(){
            this.model.bind('change', this.render);
        },
        render: function(){
            console.log('render: post/item');
            var ctemplate = Handlebars.compile(template);
            var data = {
                post: this.model.toJSON()
            };
            this.$el.append(ctemplate(data));
        }
    });
});
