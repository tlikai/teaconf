define([
    'backbone',
], function(Backbone){
    return Backbone.Model.extend({
        urlRoot: function(){
            return this.isNew() ? API_URL + '/topics' : API_URL + '/topic';
        }
    });
});
