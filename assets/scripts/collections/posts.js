define([
    'backbone',
    'models/post'
], function(Backbone, Post){
    return Backbone.Collection.extend({
        url: API_URL + '/posts',
        model: Post,
        parse: function(data){
            this.perpage = data.perpage;
            this.total = data.total;
            return data.data;
        }
    });
});
