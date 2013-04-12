define([
    'backbone',
], function(Backbone){
    return Backbone.Model.extend({
        urlRoot: function(){
            return this.isNew() ? API_URL + '/nodes' : API_URL + '/node';
        }
    });
});
