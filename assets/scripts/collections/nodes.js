define([
    'backbone',
    'models/node'
], function(Backbone, Node){
    return Backbone.Collection.extend({
        url: API_URL + '/nodes',
        model: Node,
        parse: function(data){
            this.perpage = data.perpage;
            this.total = data.total;
            return data.data;
        }
    });
});
