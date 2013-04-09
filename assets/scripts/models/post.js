define([
    'backbone',
], function(Backbone){
    return Backbone.Model.extend({
        urlRoot: function(){
            return this.isNew() ? API_URL + '/posts' : API_URL + '/post';
        }
    });
});
