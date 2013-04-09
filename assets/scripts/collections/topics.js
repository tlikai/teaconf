define([
    'backbone',
    'models/topic'
], function(Backbone, Topic){
    return Backbone.Collection.extend({
        url: API_URL + '/topics',
        model: Topic
    });
});
