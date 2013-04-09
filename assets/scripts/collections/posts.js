define([
    'backbone',
    'models/post'
], function(Backbone, Post){
    return Backbone.Collection.extend({
        url: API_URL + '/posts',
        model: Post
    });
});
