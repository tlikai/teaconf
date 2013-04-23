define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'collections/nodes',
    'text!templates/node/selector.html',
    'css!libs/chosen/chosen',
    'libs/chosen/chosen.jquery'
], function($, _, Backbone, Handlebars, Nodes, template){
    return Backbone.View.extend({
        render: function(){
            console.log('render: node/selector');
            var self = this;
            var ctemplate = Handlebars.compile(template);
            var nodes = new Nodes();
            nodes.fetch({
                success: function(){
                    var data = {
                        nodes: nodes.toJSON()
                    };
                    self.$el.html(ctemplate(data));
                    this.$('.combobox').chosen();
                }
            });
            return this;
        }
    });
});
