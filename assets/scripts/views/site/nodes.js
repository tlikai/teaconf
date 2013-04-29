define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'collections/nodes',
    'text!templates/site/nodes.html'
], function($, _, Backbone, Handlebars, Nodes, template){
    return Backbone.View.extend({
        el: $('#container'),
        render: function(){
            console.log('render: site/nodes');
            var self = this;
            var ctemplate = Handlebars.compile(template);
            var nodes = new Nodes();
            nodes.fetch({
                success: function(){
                    var data = {
                        nodes: nodes.toJSON()
                    };
                    console.log(data.nodes);
                    self.$el.html(ctemplate(data));
                }
            });
            return this;
        }
    });
});
