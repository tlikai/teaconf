define([
    'backbone',
    'models/node'
], function(Backbone, Node){
    return Backbone.Collection.extend({
        url: API_URL + '/notifications',
        model: Node,
        parse: function(data){
            this.limit = data.limit;
            this.total = data.total;
            return data.data;
        }
    });
});
