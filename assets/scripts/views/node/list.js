define([
    'jquery',
    'underscore',
    'backbone',
    'handlebars',
    'collections/nodes',
    'text!templates/node/list.html'
], function($, _, Backbone, Handlebars, Nodes, template){
    return Backbone.View.extend({
        id: 'nodeListModal',
        events: {
            'click .node-section a': function(e){
                this.$el.find('.modal').modal('hide');
            }
        },
        render: function(){
            console.log('render: node/list');
            var self = this;
            var ctemplate = Handlebars.compile(template);
            var nodes = new Nodes();
            nodes.fetch({
                success: function(){
                    var data = {
                        nodes: nodes.toJSON()
                    };
                    console.log(data.nodes);
                    self.$el.append(ctemplate(data));
                    $(document.body).append(self.$el);
                    self.$el.find('.modal').modal().on('hidden', function(){
                        self.$el.remove();
                    });
                }
            });
            return this;
        }
    });
});
