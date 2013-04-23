define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'text!templates/user/notifications/item.html'
], function($, _, Backbone, Handlebars, template){
    return Backbone.View.extend({
        render: function(){
            console.log('render: user/notifications/item');
            var self = this;
            var ctemplate = Handlebars.compile(template);
            var data = {
                notification: this.model.toJSON()
            };
            this.$el.append(ctemplate(data));
        }
    });
});
